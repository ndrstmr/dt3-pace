<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Model\Vote;
use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\VoteRepository;
use Ndrstmr\Dt3Pace\Service\FrontendUserProvider;
use Ndrstmr\Dt3Pace\Event\AfterVoteAddedEvent;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\SecurityAspect;
use TYPO3\CMS\Core\Security\RequestToken;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Psr\EventDispatcher\EventDispatcherInterface;

class SessionVoteController extends ActionController
{
    public function __construct(
        private readonly SessionRepository $sessionRepository,
        private readonly VoteRepository $voteRepository,
        private readonly FrontendUserProvider $frontendUserProvider,
        private readonly PersistenceManager $persistenceManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function voteAction(int $session): JsonResponse
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $securityAspect = SecurityAspect::provideIn($context);
        if (!$securityAspect->getReceivedRequestToken() instanceof RequestToken) {
            return new JsonResponse(['success' => false], 403);
        }
        $user = $this->frontendUserProvider->getCurrentFrontendUser();
        if ($user === null) {
            return new JsonResponse(['success' => false], 403);
        }
        /** @var Session|null $sessionObj */
        $sessionObj = $this->sessionRepository->findByUid($session);
        if ($sessionObj === null) {
            return new JsonResponse(['success' => false], 404);
        }
        if ($this->voteRepository->findOneBySessionAndVoter($sessionObj, $user) !== null) {
            return new JsonResponse(['success' => false, 'message' => 'already voted'], 400);
        }
        $vote = new Vote();
        $vote->setSession($sessionObj);
        $vote->setVoter($user);

        try {
            $this->voteRepository->add($vote);
            $sessionObj->addVote();
            $this->sessionRepository->update($sessionObj);
            $this->persistenceManager->persistAll();
            $this->eventDispatcher->dispatch(new AfterVoteAddedEvent($vote));
        } catch (UniqueConstraintViolationException $e) {
            return new JsonResponse(['success' => false, 'message' => 'already voted'], 400);
        }

        return new JsonResponse(['success' => true, 'votes' => $sessionObj->getVotes()]);
    }

}

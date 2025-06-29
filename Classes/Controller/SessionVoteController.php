<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Model\Vote;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\VoteRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\FrontendUserRepository;
use Ndrstmr\Dt3Pace\Event\AfterVoteAddedEvent;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Psr\EventDispatcher\EventDispatcherInterface;

class SessionVoteController extends ActionController
{
    public function __construct(
        private readonly SessionRepository $sessionRepository,
        private readonly VoteRepository $voteRepository,
        private readonly FrontendUserRepository $frontendUserRepository,
        private readonly PersistenceManager $persistenceManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function voteAction(int $session): JsonResponse
    {
        $user = $this->getCurrentFrontendUser();
        if ($user === null) {
            return new JsonResponse(['success' => false], 403);
        }
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
        $this->voteRepository->add($vote);
        $sessionObj->addVote();
        $this->sessionRepository->update($sessionObj);
        $this->persistenceManager->persistAll();
        $this->eventDispatcher->dispatch(new AfterVoteAddedEvent($vote));

        return new JsonResponse(['success' => true, 'votes' => $sessionObj->getVotes()]);
    }

    private function getCurrentFrontendUser(): ?\Ndrstmr\Dt3Pace\Domain\Model\FrontendUser
    {
        $uid = (int)($GLOBALS['TSFE']->fe_user->user['uid'] ?? 0);
        if ($uid === 0) {
            return null;
        }
        return $this->frontendUserRepository->findByUid($uid);
    }
}

<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Model\Vote;
use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\VoteRepository;
use Ndrstmr\Dt3Pace\Service\FrontendUserProvider;
use Ndrstmr\Dt3Pace\Event\AfterVoteAddedEvent;
use Ndrstmr\Dt3Pace\Controller\BaseAjaxController;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SessionVoteController extends BaseAjaxController
{
    public function __construct(
        private readonly SessionRepository $sessionRepository,
        private readonly VoteRepository $voteRepository,
        FrontendUserProvider $frontendUserProvider,
        private readonly PersistenceManager $persistenceManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        parent::__construct($frontendUserProvider);
        $this->eventDispatcher = $eventDispatcher;
    }

    public function voteAction(int $session): JsonResponse
    {
        $user = $this->getAuthenticatedUser();
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

        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tx_dt3pace_domain_model_vote');
        $connection->beginTransaction();
        try {
            $this->voteRepository->add($vote);
            $sessionObj->addVote();
            $this->sessionRepository->update($sessionObj);
            $this->persistenceManager->persistAll();
            $connection->commit();
            $this->eventDispatcher->dispatch(new AfterVoteAddedEvent($vote));
        } catch (UniqueConstraintViolationException $e) {
            $connection->rollBack();
            return new JsonResponse(['success' => false, 'message' => 'already voted'], 400);
        }

        return new JsonResponse(['success' => true, 'votes' => $sessionObj->getVotes()]);
    }

    /**
     * eID-compatible method for processing vote requests
     */
    public function processVoteRequest(ServerRequestInterface $request): ResponseInterface
    {
        $sessionId = (int)($request->getQueryParams()['session'] ?? $request->getParsedBody()['session'] ?? 0);
        
        if ($sessionId === 0) {
            return new JsonResponse(['success' => false, 'message' => 'Missing session parameter'], 400);
        }
        
        return $this->voteAction($sessionId);
    }

}

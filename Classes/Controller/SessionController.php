<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Model\SessionStatus;
use Ndrstmr\Dt3Pace\Domain\Model\Vote;
use Ndrstmr\Dt3Pace\Domain\Repository\RoomRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\TimeSlotRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\VoteRepository;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use Ndrstmr\Dt3Pace\Domain\Model\FrontendUser;
use Ndrstmr\Dt3Pace\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class SessionController extends ActionController
{
    public function __construct(
        private readonly SessionRepository $sessionRepository,
        private readonly VoteRepository $voteRepository,
        private readonly RoomRepository $roomRepository,
        private readonly TimeSlotRepository $timeSlotRepository,
        private readonly FrontendUserRepository $frontendUserRepository,
        private readonly PersistenceManager $persistenceManager
    ) {
    }

    public function listAction(): void
    {
        $sessions = $this->sessionRepository->findPublishedAndScheduled();
        $grouped = [];
        foreach ($sessions as $session) {
            $date = $session->getTimeSlot()?->getStart()->format('Y-m-d');
            $grouped[$date][] = $session;
        }
        ksort($grouped);
        $this->view->assign('sessionsByDay', $grouped);
    }

    public function gridAction(): void
    {
        $sessions = $this->sessionRepository->findPublishedAndScheduled();
        $grid = [];
        foreach ($sessions as $session) {
            $slot = $session->getTimeSlot()?->getUid();
            $room = $session->getRoom()?->getUid();
            if ($slot && $room) {
                $grid[$slot][$room] = $session;
            }
        }
        $this->view->assignMultiple([
            'rooms' => $this->roomRepository->findAll(),
            'timeSlots' => $this->timeSlotRepository->findAll(),
            'grid' => $grid,
        ]);
    }

    #[IgnoreValidation('session')]
    public function showAction(Session $session): void
    {
        $this->view->assign('session', $session);
    }

    public function newAction(): void
    {
        if ($this->getCurrentFrontendUser() === null) {
            throw new \RuntimeException('Login required', 166832);
        }
    }

    public function createAction(Session $newSession): void
    {
        $user = $this->getCurrentFrontendUser();
        if ($user === null) {
            throw new \RuntimeException('Login required', 166833);
        }
        $newSession->setStatus(SessionStatus::PROPOSED);
        $newSession->setProposer($user);
        $this->sessionRepository->add($newSession);
        $this->persistenceManager->persistAll();
        $this->redirect('listProposals');
    }

    public function listProposalsAction(): void
    {
        $this->view->assign('sessions', $this->sessionRepository->findProposed());
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

        return new JsonResponse(['success' => true, 'votes' => $sessionObj->getVotes()]);
    }

    public function listJsonAction(): JsonResponse
    {
        $sessions = $this->sessionRepository->findPublishedAndScheduled();
        $data = [];
        foreach ($sessions as $session) {
            $data[] = [
                'id' => $session->getUid(),
                'title' => $session->getTitle(),
                'room' => $session->getRoom()?->getUid(),
                'timeslot' => $session->getTimeSlot()?->getUid(),
            ];
        }

        return new JsonResponse($data);
    }

    private function getCurrentFrontendUser(): ?FrontendUser
    {
        $uid = (int)($GLOBALS['TSFE']->fe_user->user['uid'] ?? 0);
        if ($uid === 0) {
            return null;
        }
        return $this->frontendUserRepository->findByUid($uid);
    }
}

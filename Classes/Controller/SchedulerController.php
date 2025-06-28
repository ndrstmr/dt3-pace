<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Model\SessionStatus;
use Ndrstmr\Dt3Pace\Domain\Repository\RoomRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\TimeSlotRepository;
use TYPO3\CMS\Extbase\Annotation\Access;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Core\Http\JsonResponse;

class SchedulerController extends ActionController
{
    public function __construct(
        private readonly SessionRepository $sessionRepository,
        private readonly RoomRepository $roomRepository,
        private readonly TimeSlotRepository $timeSlotRepository,
        private readonly PersistenceManager $persistenceManager
    ) {
    }

    public function initializeView(ViewInterface $view): void
    {
        $view->assign('rooms', $this->roomRepository->findAll());
        $view->assign('timeSlots', $this->timeSlotRepository->findAll());
        $view->assign('sessions', $this->sessionRepository->findProposedOrUnscheduled());
    }

    #[Access('user')]
    public function showAction(): void
    {
    }

    #[Access('user')]
    public function updateSessionSlotAction(int $session, int $room, int $timeSlot): JsonResponse
    {
        $sessionObj = $this->sessionRepository->findByUid($session);
        $roomObj = $this->roomRepository->findByUid($room);
        $slotObj = $this->timeSlotRepository->findByUid($timeSlot);
        if ($sessionObj === null || $roomObj === null || $slotObj === null) {
            return new JsonResponse(['success' => false], 400);
        }
        $sessionObj->setRoom($roomObj);
        $sessionObj->setTimeSlot($slotObj);
        $sessionObj->setStatus(SessionStatus::SCHEDULED);
        $this->sessionRepository->update($sessionObj);
        $this->persistenceManager->persistAll();
        return new JsonResponse(['success' => true]);
    }
}

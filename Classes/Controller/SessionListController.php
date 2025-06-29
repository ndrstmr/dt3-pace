<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Repository\RoomRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\TimeSlotRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SessionListController extends ActionController
{
    public function __construct(
        private readonly SessionRepository $sessionRepository,
        private readonly RoomRepository $roomRepository,
        private readonly TimeSlotRepository $timeSlotRepository
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
}

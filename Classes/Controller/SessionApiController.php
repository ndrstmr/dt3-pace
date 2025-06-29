<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SessionApiController extends ActionController
{
    public function __construct(private readonly SessionRepository $sessionRepository)
    {
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
}

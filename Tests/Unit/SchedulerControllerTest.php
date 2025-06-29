<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Tests\Unit;

use Ndrstmr\Dt3Pace\Controller\SchedulerController;
use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Model\SessionStatus;
use Ndrstmr\Dt3Pace\Domain\Repository\RoomRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\TimeSlotRepository;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Psr\EventDispatcher\EventDispatcherInterface;

class SchedulerControllerTest extends TestCase
{
    public function testUpdateSessionSlotActionUpdatesSession(): void
    {
        $session = $this->createMock(Session::class);
        $session->method('getStatus')->willReturn(SessionStatus::PROPOSED);
        $session->expects($this->once())->method('setRoom');
        $session->expects($this->once())->method('setTimeSlot');
        $session->expects($this->once())->method('setStatus');

        $sessionRepository = $this->createMock(SessionRepository::class);
        $roomRepository = $this->createMock(RoomRepository::class);
        $slotRepository = $this->createMock(TimeSlotRepository::class);
        $room = new \Ndrstmr\Dt3Pace\Domain\Model\Room();
        $slot = new \Ndrstmr\Dt3Pace\Domain\Model\TimeSlot();
        $persistenceManager = $this->createMock(PersistenceManager::class);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $sessionRepository->method('findByUid')->willReturn($session);
        $roomRepository->method('findByUid')->willReturn($room);
        $slotRepository->method('findByUid')->willReturn($slot);

        $sessionRepository->expects($this->once())->method('update')->with($session);
        $persistenceManager->expects($this->once())->method('persistAll');

        $controller = new SchedulerController($sessionRepository, $roomRepository, $slotRepository, $persistenceManager, $eventDispatcher);
        $response = $controller->updateSessionSlotAction(1, 2, 3);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $payload = json_decode((string)$response->getBody(), true);
        $this->assertSame(['success' => true], $payload);
    }
}

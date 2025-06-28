<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Tests\Unit\Controller;

use Ndrstmr\Dt3Pace\Controller\SessionController;
use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Model\SessionStatus;
use Ndrstmr\Dt3Pace\Domain\Model\Vote;
use Ndrstmr\Dt3Pace\Domain\Repository\RoomRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\TimeSlotRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\VoteRepository;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Http\JsonResponse;
use Ndrstmr\Dt3Pace\Domain\Model\FrontendUser;
use Ndrstmr\Dt3Pace\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse as CoreJsonResponse;

class TestableSessionController extends SessionController
{
    protected function redirect(
        ?string $actionName,
        ?string $controllerName = null,
        ?string $extensionName = null,
        ?array $arguments = null,
        ?int $pageUid = null,
        $_ = null,
        int $statusCode = 303
    ): ResponseInterface {
        // Avoid accessing request during unit tests
        return new CoreJsonResponse(null, $statusCode);
    }
}

class SessionControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $GLOBALS['TSFE'] = new class () {
            public $fe_user;
            public function __construct()
            {
                $this->fe_user = new class () {
                    public $user = ['uid' => 1];
                };
            }
        };
    }

    public function testCreateActionAddsSession(): void
    {
        $session = new Session();
        $sessionRepository = $this->createMock(SessionRepository::class);
        $voteRepository = $this->createMock(VoteRepository::class);
        $roomRepository = $this->createMock(RoomRepository::class);
        $slotRepository = $this->createMock(TimeSlotRepository::class);
        $frontendUserRepository = $this->createMock(FrontendUserRepository::class);
        $persistenceManager = $this->createMock(PersistenceManager::class);

        $user = new FrontendUser();
        $frontendUserRepository->method('findByUid')->willReturn($user);

        $sessionRepository->expects($this->once())->method('add')->with($session);
        $persistenceManager->expects($this->once())->method('persistAll');

        $controller = new TestableSessionController($sessionRepository, $voteRepository, $roomRepository, $slotRepository, $frontendUserRepository, $persistenceManager);
        $controller->createAction($session);

        $this->assertSame(SessionStatus::PROPOSED, $session->getStatus());
        $this->assertSame($user, $session->getProposer());
    }

    public function testVoteActionCreatesVote(): void
    {
        $session = new Session();
        $session->_setProperty('uid', 5);
        $sessionRepository = $this->createMock(SessionRepository::class);
        $voteRepository = $this->createMock(VoteRepository::class);
        $roomRepository = $this->createMock(RoomRepository::class);
        $slotRepository = $this->createMock(TimeSlotRepository::class);
        $frontendUserRepository = $this->createMock(FrontendUserRepository::class);
        $persistenceManager = $this->createMock(PersistenceManager::class);

        $user = new FrontendUser();
        $user->_setProperty('uid', 1);
        $frontendUserRepository->method('findByUid')->willReturn($user);
        $sessionRepository->method('findByUid')->willReturn($session);
        $voteRepository->method('findOneBySessionAndVoter')->willReturn(null);

        $voteRepository->expects($this->once())->method('add')->with($this->isInstanceOf(Vote::class));
        $sessionRepository->expects($this->once())->method('update')->with($session);
        $persistenceManager->expects($this->once())->method('persistAll');

        $controller = new TestableSessionController($sessionRepository, $voteRepository, $roomRepository, $slotRepository, $frontendUserRepository, $persistenceManager);
        $response = $controller->voteAction(5);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $payload = json_decode((string)$response->getBody(), true);
        $this->assertTrue($payload['success']);
        $this->assertSame(1, $payload['votes']);
    }
}

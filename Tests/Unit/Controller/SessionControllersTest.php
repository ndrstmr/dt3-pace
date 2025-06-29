<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Tests\Unit\Controller;

use Ndrstmr\Dt3Pace\Controller\SessionProposalController;
use Ndrstmr\Dt3Pace\Controller\SessionVoteController;
use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Model\SessionStatus;
use Ndrstmr\Dt3Pace\Domain\Model\Vote;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\VoteRepository;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Http\JsonResponse;
use Ndrstmr\Dt3Pace\Domain\Model\FrontendUser;
use Ndrstmr\Dt3Pace\Service\FrontendUserProvider;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse as CoreJsonResponse;

class TestableSessionProposalController extends SessionProposalController
{
    /**
     * @param array<string, mixed>|null $arguments
     */
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

class TestableSessionVoteController extends SessionVoteController
{
    /**
     * @param array<string, mixed>|null $arguments
     */
    protected function redirect(
        ?string $actionName,
        ?string $controllerName = null,
        ?string $extensionName = null,
        ?array $arguments = null,
        ?int $pageUid = null,
        $_ = null,
        int $statusCode = 303
    ): ResponseInterface {
        return new CoreJsonResponse(null, $statusCode);
    }
}

class SessionControllerTest extends TestCase
{
    public function testCreateActionAddsSession(): void
    {
        $session = new Session();
        $sessionRepository = $this->createMock(SessionRepository::class);
        $frontendUserProvider = $this->createMock(FrontendUserProvider::class);
        $persistenceManager = $this->createMock(PersistenceManager::class);

        $user = new FrontendUser();
        $frontendUserProvider->method('getCurrentFrontendUser')->willReturn($user);

        $sessionRepository->expects($this->once())->method('add')->with($session);
        $persistenceManager->expects($this->once())->method('persistAll');

        $controller = new TestableSessionProposalController($sessionRepository, $frontendUserProvider, $persistenceManager);
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
        $frontendUserProvider = $this->createMock(FrontendUserProvider::class);
        $persistenceManager = $this->createMock(PersistenceManager::class);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $user = new FrontendUser();
        $user->_setProperty('uid', 1);
        $frontendUserProvider->method('getCurrentFrontendUser')->willReturn($user);
        $sessionRepository->method('findByUid')->willReturn($session);
        $voteRepository->method('findOneBySessionAndVoter')->willReturn(null);

        $voteRepository->expects($this->once())->method('add')->with($this->isInstanceOf(Vote::class));
        $sessionRepository->expects($this->once())->method('update')->with($session);
        $persistenceManager->expects($this->once())->method('persistAll');

        $controller = new TestableSessionVoteController($sessionRepository, $voteRepository, $frontendUserProvider, $persistenceManager, $eventDispatcher);
        $response = $controller->voteAction(5);

        $this->assertInstanceOf(JsonResponse::class, $response);
        /** @var array{success: bool, votes: int} $payload */
        $payload = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertTrue($payload['success']);
        $this->assertSame(1, $payload['votes']);
    }
}

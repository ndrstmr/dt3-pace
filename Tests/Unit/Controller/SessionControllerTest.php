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
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\SecurityAspect;
use TYPO3\CMS\Core\Security\RequestToken;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Ndrstmr\Dt3Pace\Domain\Model\FrontendUser;
use Ndrstmr\Dt3Pace\Service\FrontendUserProvider;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse as CoreJsonResponse;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;

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

    protected function redirectToUri(string|\Psr\Http\Message\UriInterface $uri, $_ = null, int $statusCode = 303): ResponseInterface
    {
        return new CoreJsonResponse(null, $statusCode);
    }

    public function addFlashMessage(
        string $message,
        string $title = '',
        \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity $severity = \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::OK,
        bool $storeInSession = true
    ): void {
        // no-op in tests
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
    private Context $context;
    /** @var ConnectionPool&\TYPO3\CMS\Core\SingletonInterface */
    private ConnectionPool $connectionPool;
    private Connection $mockConnection;

    protected function setUp(): void
    {
        $this->context = new Context();
        SecurityAspect::provideIn($this->context)
            ->setReceivedRequestToken(RequestToken::create('test'));
        GeneralUtility::setSingletonInstance(Context::class, $this->context);

        $this->mockConnection = $this->createMock(Connection::class);

        $this->connectionPool = new class ($this->mockConnection) extends ConnectionPool implements \TYPO3\CMS\Core\SingletonInterface {
            public function __construct(private Connection $connection) {}
            public function getConnectionForTable(string $tableName): Connection
            {
                return $this->connection;
            }
            public function getConnectionByName(string $connectionName): Connection
            {
                return $this->connection;
            }
        };
        GeneralUtility::setSingletonInstance(ConnectionPool::class, $this->connectionPool);
    }

    protected function tearDown(): void
    {
        GeneralUtility::removeSingletonInstance(Context::class, $this->context);
        GeneralUtility::removeSingletonInstance(ConnectionPool::class, $this->connectionPool);
    }

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
        $response = $controller->createAction($session);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertSame(SessionStatus::PROPOSED, $session->getStatus());
        $this->assertSame($user, $session->getProposer());
    }

    public function testNewActionRedirectsWhenNotLoggedIn(): void
    {
        $sessionRepository = $this->createMock(SessionRepository::class);
        $frontendUserProvider = $this->createMock(FrontendUserProvider::class);
        $persistenceManager = $this->createMock(PersistenceManager::class);

        $frontendUserProvider->method('getCurrentFrontendUser')->willReturn(null);

        $controller = new TestableSessionProposalController($sessionRepository, $frontendUserProvider, $persistenceManager);
        $response = $controller->newAction();

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(303, $response->getStatusCode());
    }

    public function testCreateActionRedirectsWhenNotLoggedIn(): void
    {
        $session = new Session();
        $sessionRepository = $this->createMock(SessionRepository::class);
        $frontendUserProvider = $this->createMock(FrontendUserProvider::class);
        $persistenceManager = $this->createMock(PersistenceManager::class);

        $frontendUserProvider->method('getCurrentFrontendUser')->willReturn(null);

        $controller = new TestableSessionProposalController($sessionRepository, $frontendUserProvider, $persistenceManager);
        $response = $controller->createAction($session);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(303, $response->getStatusCode());
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

    public function testVoteActionHandlesDuplicateVoteException(): void
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

        $voteRepository->expects($this->once())->method('add');
        $sessionRepository->expects($this->once())->method('update')->with($session);
        $driverException = new class ('error') extends \Doctrine\DBAL\Driver\AbstractException {
        };
        $persistenceManager->method('persistAll')->willThrowException(new UniqueConstraintViolationException($driverException, null));

        $controller = new TestableSessionVoteController($sessionRepository, $voteRepository, $frontendUserProvider, $persistenceManager, $eventDispatcher);
        $response = $controller->voteAction(5);

        $this->assertInstanceOf(JsonResponse::class, $response);
        /** @var array{success: bool} $payload */
        $payload = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertFalse($payload['success']);
    }

    public function testConcurrentVotesOnlyPersistSingleRecord(): void
    {
        $session1 = new Session();
        $session1->_setProperty('uid', 5);
        $session2 = new Session();
        $session2->_setProperty('uid', 5);

        $sessionRepository = $this->createMock(SessionRepository::class);
        $voteRepository = $this->createMock(VoteRepository::class);
        $frontendUserProvider = $this->createMock(FrontendUserProvider::class);
        $persistenceManager = $this->createMock(PersistenceManager::class);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $user = new FrontendUser();
        $user->_setProperty('uid', 1);

        $frontendUserProvider->method('getCurrentFrontendUser')->willReturn($user);
        $sessionRepository->method('findByUid')->willReturnOnConsecutiveCalls($session1, $session2);
        $voteRepository->method('findOneBySessionAndVoter')->willReturn(null);

        $callCount = 0;
        $persistenceManager->method('persistAll')->willReturnCallback(static function () use (&$callCount) {
            ++$callCount;
            if ($callCount === 2) {
                $driverException = new class ('error') extends \Doctrine\DBAL\Driver\AbstractException {
                };
                throw new UniqueConstraintViolationException($driverException, null);
            }
            return null;
        });

        $controller = new TestableSessionVoteController($sessionRepository, $voteRepository, $frontendUserProvider, $persistenceManager, $eventDispatcher);

        $response1 = $controller->voteAction(5);
        /** @var array{success: bool} $payload1 */
        $payload1 = json_decode((string)$response1->getBody(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertTrue($payload1['success']);

        $response2 = $controller->voteAction(5);
        /** @var array{success: bool} $payload2 */
        $payload2 = json_decode((string)$response2->getBody(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertFalse($payload2['success']);
    }
}

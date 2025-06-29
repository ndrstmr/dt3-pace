<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Tests\Unit\Controller;

use Ndrstmr\Dt3Pace\Controller\NoteApiController;
use Ndrstmr\Dt3Pace\Domain\Model\Note;
use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Model\FrontendUser;
use Ndrstmr\Dt3Pace\Domain\Repository\NoteRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\FrontendUserRepository;
use Ndrstmr\Dt3Pace\Service\FrontendUserProvider;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\SecurityAspect;
use TYPO3\CMS\Core\Security\RequestToken;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use PHPUnit\Framework\TestCase;

class NoteControllerTest extends TestCase
{
    private Context $context;

    protected function setUp(): void
    {
        $this->context = new Context();
        $frontendUser = new \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication();
        $frontendUser->user = ['uid' => 1];
        $this->context->setAspect('frontend.user', $frontendUser->createUserAspect());
        $securityAspect = SecurityAspect::provideIn($this->context);
        $securityAspect->setReceivedRequestToken(RequestToken::create('test'));
        GeneralUtility::setSingletonInstance(Context::class, $this->context);
    }

    protected function tearDown(): void
    {
        GeneralUtility::removeSingletonInstance(Context::class, $this->context);
    }

    public function testUpdateActionCreatesNote(): void
    {
        $noteRepository = $this->createMock(NoteRepository::class);
        $sessionRepository = $this->createMock(SessionRepository::class);
        $frontendUserRepository = $this->createMock(FrontendUserRepository::class);
        $frontendUserProvider = new \Ndrstmr\Dt3Pace\Service\FrontendUserProvider(
            $frontendUserRepository,
            $this->context
        );
        $persistenceManager = $this->createMock(PersistenceManager::class);

        $session = new Session();
        $session->_setProperty('uid', 5);
        $user = new FrontendUser();
        $user->_setProperty('uid', 1);

        $sessionRepository->method('findByUid')->willReturn($session);
        $frontendUserRepository->method('findByUid')->willReturn($user);
        $noteRepository->method('findOneByUserAndSession')->willReturn(null);

        $noteRepository->expects($this->once())->method('add')->with($this->isInstanceOf(Note::class));
        $persistenceManager->expects($this->once())->method('persistAll');

        $controller = new NoteApiController($noteRepository, $sessionRepository, $frontendUserProvider, $persistenceManager);
        $response = $controller->updateAction(5, 'text');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $payload = json_decode((string)$response->getBody(), true);
        $this->assertTrue($payload['success']);
    }
}

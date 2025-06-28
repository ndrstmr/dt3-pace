<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Tests\Unit\Controller;

use Ndrstmr\Dt3Pace\Controller\NoteController;
use Ndrstmr\Dt3Pace\Domain\Model\Note;
use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Model\FrontendUser;
use Ndrstmr\Dt3Pace\Domain\Repository\NoteRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Core\Http\JsonResponse;
use PHPUnit\Framework\TestCase;

class NoteControllerTest extends TestCase
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

    public function testUpdateActionCreatesNote(): void
    {
        $noteRepository = $this->createMock(NoteRepository::class);
        $sessionRepository = $this->createMock(SessionRepository::class);
        $frontendUserRepository = $this->createMock(FrontendUserRepository::class);
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

        $controller = new NoteController($noteRepository, $sessionRepository, $frontendUserRepository, $persistenceManager);
        $response = $controller->updateAction(5, 'text');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $payload = json_decode((string)$response->getBody(), true);
        $this->assertTrue($payload['success']);
    }
}

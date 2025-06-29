<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Tests\Functional;

use Ndrstmr\Dt3Pace\Controller\NoteApiController;
use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Model\FrontendUser;
use Ndrstmr\Dt3Pace\Domain\Repository\NoteRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\FrontendUserRepository;
use Ndrstmr\Dt3Pace\Service\FrontendUserProvider;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class NoteAjaxTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['typo3conf/ext/dt3_pace'];

    public function testUpdateActionReturnsJson(): void
    {
        $noteRepository = $this->createMock(NoteRepository::class);
        $sessionRepository = $this->createMock(SessionRepository::class);
        $frontendUserRepository = $this->createMock(FrontendUserRepository::class);
        $frontendUserProvider = new \Ndrstmr\Dt3Pace\Service\FrontendUserProvider($frontendUserRepository);
        $persistenceManager = $this->createMock(PersistenceManager::class);

        $session = new Session();
        $session->_setProperty('uid', 5);
        $user = new FrontendUser();
        $user->_setProperty('uid', 1);

        $sessionRepository->method('findByUid')->willReturn($session);
        $frontendUserRepository->method('findByUid')->willReturn($user);
        $noteRepository->method('findOneByUserAndSession')->willReturn(null);

        $controller = new NoteApiController($noteRepository, $sessionRepository, $frontendUserProvider, $persistenceManager);
        $GLOBALS['TSFE'] = new class ($user) {
            public $fe_user;
            public function __construct($user)
            {
                $this->fe_user = new class ($user) {
                    public function __construct(public $user)
                    {
                    }
                };
            }
        };

        $response = $controller->updateAction(5, 'abc');
        $this->assertSame(200, $response->getStatusCode());
    }
}

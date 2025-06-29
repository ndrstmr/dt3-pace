<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Model\SessionStatus;
use Ndrstmr\Dt3Pace\Domain\Repository\FrontendUserRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class SessionProposalController extends ActionController
{
    public function __construct(
        private readonly SessionRepository $sessionRepository,
        private readonly FrontendUserRepository $frontendUserRepository,
        private readonly PersistenceManager $persistenceManager
    ) {
    }

    public function newAction(): void
    {
        if ($this->getCurrentFrontendUser() === null) {
            throw new \RuntimeException('Login required', 166832);
        }
    }

    public function createAction(Session $newSession): void
    {
        $user = $this->getCurrentFrontendUser();
        if ($user === null) {
            throw new \RuntimeException('Login required', 166833);
        }
        $newSession->setStatus(SessionStatus::PROPOSED);
        $newSession->setProposer($user);
        $this->sessionRepository->add($newSession);
        $this->persistenceManager->persistAll();
        $this->redirect('listProposals');
    }

    public function listProposalsAction(): void
    {
        $this->view->assign('sessions', $this->sessionRepository->findProposed());
    }

    private function getCurrentFrontendUser(): ?\Ndrstmr\Dt3Pace\Domain\Model\FrontendUser
    {
        $uid = (int)($GLOBALS['TSFE']->fe_user->user['uid'] ?? 0);
        if ($uid === 0) {
            return null;
        }
        return $this->frontendUserRepository->findByUid($uid);
    }
}

<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Model\SessionStatus;
use Ndrstmr\Dt3Pace\Service\FrontendUserProvider;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class SessionProposalController extends ActionController
{
    public function __construct(
        private readonly SessionRepository $sessionRepository,
        private readonly FrontendUserProvider $frontendUserProvider,
        private readonly PersistenceManager $persistenceManager
    ) {
    }

    public function newAction(): void
    {
        if ($this->frontendUserProvider->getCurrentFrontendUser() === null) {
            throw new \RuntimeException('Login required', 166832);
        }
    }

    public function createAction(Session $newSession): void
    {
        $user = $this->frontendUserProvider->getCurrentFrontendUser();
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

}

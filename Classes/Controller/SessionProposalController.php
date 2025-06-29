<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Model\SessionStatus;
use Ndrstmr\Dt3Pace\Service\FrontendUserProvider;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Psr\Http\Message\ResponseInterface;

class SessionProposalController extends ActionController
{
    public function __construct(
        private readonly SessionRepository $sessionRepository,
        private readonly FrontendUserProvider $frontendUserProvider,
        private readonly PersistenceManager $persistenceManager
    ) {
    }

    public function newAction(): ResponseInterface
    {
        if ($this->frontendUserProvider->getCurrentFrontendUser() === null) {
            $this->addFlashMessage('Please log in to propose a session.');
            return $this->redirectToUri('/login');
        }

        return $this->htmlResponse();
    }

    public function createAction(Session $newSession): ResponseInterface
    {
        $user = $this->frontendUserProvider->getCurrentFrontendUser();
        if ($user === null) {
            $this->addFlashMessage('Please log in to propose a session.');
            return $this->redirectToUri('/login');
        }
        $newSession->setStatus(SessionStatus::PROPOSED);
        $newSession->setProposer($user);
        $this->sessionRepository->add($newSession);
        $this->persistenceManager->persistAll();
        return $this->redirect('listProposals');
    }

    public function listProposalsAction(): void
    {
        $this->view->assign('sessions', $this->sessionRepository->findProposed());
    }

}

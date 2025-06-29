<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Repository\NoteRepository;
use Ndrstmr\Dt3Pace\Service\FrontendUserProvider;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class NoteController extends ActionController
{
    public function __construct(
        private readonly NoteRepository $noteRepository,
        private readonly FrontendUserProvider $frontendUserProvider
    ) {
    }

    public function summaryAction(): void
    {
        $user = $this->frontendUserProvider->getCurrentFrontendUser();
        if ($user === null) {
            $this->view->assign('notes', []);
            return;
        }
        $notes = $this->noteRepository->findByUser($user);
        $this->view->assign('notes', $notes);
    }
}

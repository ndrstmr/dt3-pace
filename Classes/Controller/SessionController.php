<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Repository\NoteRepository;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use Ndrstmr\Dt3Pace\Service\FrontendUserProvider;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SessionController extends ActionController
{
    public function __construct(
        private readonly NoteRepository $noteRepository,
        private readonly FrontendUserProvider $frontendUserProvider
    ) {
    }


    #[IgnoreValidation('session')]
    public function showAction(Session $session): void
    {
        $user = $this->frontendUserProvider->getCurrentFrontendUser();
        $note = null;
        if ($user !== null) {
            $note = $this->noteRepository->findOneByUserAndSession($user, $session);
        }
        $this->view->assignMultiple([
            'session' => $session,
            'note' => $note,
            'isLoggedIn' => $user !== null,
        ]);
    }


}


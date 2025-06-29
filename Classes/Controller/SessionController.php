<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Repository\NoteRepository;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use Ndrstmr\Dt3Pace\Domain\Model\FrontendUser;
use Ndrstmr\Dt3Pace\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SessionController extends ActionController
{
    public function __construct(
        private readonly FrontendUserRepository $frontendUserRepository,
        private readonly NoteRepository $noteRepository
    ) {
    }


    #[IgnoreValidation('session')]
    public function showAction(Session $session): void
    {
        $user = $this->getCurrentFrontendUser();
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


    private function getCurrentFrontendUser(): ?FrontendUser
    {
        $uid = (int)($GLOBALS['TSFE']->fe_user->user['uid'] ?? 0);
        if ($uid === 0) {
            return null;
        }
        return $this->frontendUserRepository->findByUid($uid);
    }
}

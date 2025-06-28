<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Model\Note;
use Ndrstmr\Dt3Pace\Domain\Repository\NoteRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class NoteController extends ActionController
{
    public function __construct(
        private readonly NoteRepository $noteRepository,
        private readonly SessionRepository $sessionRepository,
        private readonly FrontendUserRepository $frontendUserRepository,
        private readonly PersistenceManager $persistenceManager
    ) {
    }

    public function updateAction(int $session, string $note): JsonResponse
    {
        $user = $this->getCurrentFrontendUser();
        if ($user === null) {
            return new JsonResponse(['success' => false], 403);
        }
        $sessionObj = $this->sessionRepository->findByUid($session);
        if ($sessionObj === null) {
            return new JsonResponse(['success' => false], 404);
        }
        $noteObj = $this->noteRepository->findOneByUserAndSession($user, $sessionObj);
        if ($noteObj === null) {
            $noteObj = new Note();
            $noteObj->setUser($user);
            $noteObj->setSession($sessionObj);
            $this->noteRepository->add($noteObj);
        }
        $noteObj->setNoteText($note);
        $this->persistenceManager->persistAll();
        return new JsonResponse(['success' => true]);
    }

    public function summaryAction(): void
    {
        $user = $this->getCurrentFrontendUser();
        if ($user === null) {
            $this->view->assign('notes', []);
            return;
        }
        $notes = $this->noteRepository->findByUser($user);
        $this->view->assign('notes', $notes);
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

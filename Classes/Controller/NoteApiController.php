<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Model\Note;
use Ndrstmr\Dt3Pace\Domain\Repository\NoteRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use Ndrstmr\Dt3Pace\Service\FrontendUserProvider;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\SecurityAspect;
use TYPO3\CMS\Core\Security\RequestToken;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class NoteApiController extends ActionController
{
    public function __construct(
        private readonly NoteRepository $noteRepository,
        private readonly SessionRepository $sessionRepository,
        private readonly FrontendUserProvider $frontendUserProvider,
        private readonly PersistenceManager $persistenceManager
    ) {
    }

    public function updateAction(int $session, string $note): JsonResponse
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $securityAspect = SecurityAspect::provideIn($context);
        if (!$securityAspect->getReceivedRequestToken() instanceof RequestToken) {
            return new JsonResponse(['success' => false], 403);
        }
        $user = $this->frontendUserProvider->getCurrentFrontendUser();
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
}

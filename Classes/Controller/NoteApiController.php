<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Model\Note;
use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Repository\NoteRepository;
use Ndrstmr\Dt3Pace\Domain\Repository\SessionRepository;
use Ndrstmr\Dt3Pace\Service\FrontendUserProvider;
use TYPO3\CMS\Core\Http\JsonResponse;
use Ndrstmr\Dt3Pace\Controller\BaseAjaxController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NoteApiController extends BaseAjaxController
{
    public function __construct(
        private readonly NoteRepository $noteRepository,
        private readonly SessionRepository $sessionRepository,
        FrontendUserProvider $frontendUserProvider,
        private readonly PersistenceManager $persistenceManager
    ) {
        parent::__construct($frontendUserProvider);
    }

    public function updateAction(int $session, string $note): JsonResponse
    {
        $user = $this->getAuthenticatedUser();
        if ($user === null) {
            return new JsonResponse(['success' => false], 403);
        }
        /** @var Session|null $sessionObj */
        $sessionObj = $this->sessionRepository->findByUid($session);
        if ($sessionObj === null) {
            return new JsonResponse(['success' => false], 404);
        }
        /** @var Note|null $noteObj */
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

    /**
     * eID-compatible method for processing note update requests
     */
    public function processUpdateRequest(ServerRequestInterface $request): ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        $parsedBody = \is_array($parsedBody) ? $parsedBody : [];
        $sessionId = (int)($request->getQueryParams()['session'] ?? $parsedBody['session'] ?? 0);
        $note = (string)($request->getQueryParams()['note'] ?? $parsedBody['note'] ?? '');

        if ($sessionId === 0) {
            return new JsonResponse(['success' => false, 'message' => 'Missing session parameter'], 400);
        }

        return $this->updateAction($sessionId, $note);
    }
}

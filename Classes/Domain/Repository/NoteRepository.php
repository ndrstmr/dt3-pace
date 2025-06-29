<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Domain\Repository;

use Ndrstmr\Dt3Pace\Domain\Model\FrontendUser;
use Ndrstmr\Dt3Pace\Domain\Model\Note;
use Ndrstmr\Dt3Pace\Domain\Model\Session;
use TYPO3\CMS\Extbase\Persistence\Repository;

class NoteRepository extends Repository
{
    public function findOneByUserAndSession(FrontendUser $user, Session $session): ?Note
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('user', $user->getUid()),
                $query->equals('session', $session->getUid())
            )
        );
        /** @var Note|null $note */
        $note = $query->execute()->getFirst();
        return $note;
    }

    public function findByUser(FrontendUser $user): array
    {
        $query = $this->createQuery();
        $query->matching($query->equals('user', $user->getUid()));
        return $query->execute()->toArray();
    }
}

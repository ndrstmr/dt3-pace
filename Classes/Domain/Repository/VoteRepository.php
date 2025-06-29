<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Domain\Repository;

use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Model\Vote;
use Ndrstmr\Dt3Pace\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\Repository;

class VoteRepository extends Repository
{
    public function findOneBySessionAndVoter(Session $session, FrontendUser $voter): ?Vote
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('session', $session->getUid()),
                $query->equals('voter', $voter->getUid())
            )
        );
        /** @var Vote|null $vote */
        $vote = $query->execute()->getFirst();
        return $vote;
    }
}

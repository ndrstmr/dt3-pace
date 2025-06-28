<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Domain\Repository;

use Ndrstmr\Dt3Pace\Domain\Model\SessionStatus;
use TYPO3\CMS\Extbase\Persistence\Repository;

class SessionRepository extends Repository
{
    public function findProposedOrUnscheduled(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalOr(
                $query->equals('status', SessionStatus::PROPOSED->value),
                $query->logicalAnd(
                    $query->equals('status', SessionStatus::SCHEDULED->value),
                    $query->logicalOr(
                        $query->equals('room', 0),
                        $query->equals('timeSlot', 0)
                    )
                )
            )
        );
        $query->setOrderings(['votes' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING]);
        return $query->execute()->toArray();
    }
}

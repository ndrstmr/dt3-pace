<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Domain\Repository;

use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Model\SessionStatus;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
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
        $query->setOrderings(['votes' => QueryInterface::ORDER_DESCENDING]);
        return $query->execute()->toArray();
    }

    public function findPublishedAndScheduled(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('isPublished', true),
                $query->equals('status', SessionStatus::SCHEDULED->value)
            )
        );
        $query->setOrderings(['timeSlot' => QueryInterface::ORDER_ASCENDING]);
        return $query->execute()->toArray();
    }

    public function findProposed(): array
    {
        $query = $this->createQuery();
        $query->matching($query->equals('status', SessionStatus::PROPOSED->value));
        return $query->execute()->toArray();
    }
}

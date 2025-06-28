<?php
declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\CMS\Extbase\Domain\Model\AbstractEntity;

/**
 * Represents a time slot within the schedule.
 */
#[ORM\Entity]
#[ORM\Table(name: 'tx_dt3pace_domain_model_timeslot')]
class TimeSlot extends AbstractEntity
{
    #[ORM\Column(type: 'datetime_immutable')]
    protected \DateTimeImmutable $start;

    #[ORM\Column(type: 'datetime_immutable')]
    protected \DateTimeImmutable $end;

    public function __construct()
    {
        $this->start = new \DateTimeImmutable();
        $this->end = new \DateTimeImmutable();
    }

    public function getStart(): \DateTimeImmutable
    {
        return $this->start;
    }

    public function setStart(\DateTimeImmutable $start): void
    {
        $this->start = $start;
    }

    public function getEnd(): \DateTimeImmutable
    {
        return $this->end;
    }

    public function setEnd(\DateTimeImmutable $end): void
    {
        $this->end = $end;
    }
}

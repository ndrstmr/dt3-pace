<?php
declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\CMS\Extbase\Domain\Model\AbstractEntity;

/**
 * Conference room.
 */
#[ORM\Entity]
#[ORM\Table(name: 'tx_dt3pace_domain_model_room')]
class Room extends AbstractEntity
{
    #[ORM\Column(type: 'string', length: 255)]
    protected string $name = '';

    #[ORM\Column(type: 'integer', nullable: true)]
    protected int $capacity = 0;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): void
    {
        $this->capacity = $capacity;
    }
}

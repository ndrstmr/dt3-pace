<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\CMS\Extbase\Domain\Model\AbstractEntity;

/**
 * Conference track.
 */
#[ORM\Entity]
#[ORM\Table(name: 'tx_dt3pace_domain_model_track')]
class Track extends AbstractEntity
{
    #[ORM\Column(type: 'string', length: 255)]
    protected string $title = '';

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}

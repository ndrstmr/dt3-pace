<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\CMS\Extbase\Domain\Model\AbstractEntity;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

/**
 * Represents a conference speaker.
 */
#[ORM\Entity]
#[ORM\Table(name: 'tx_dt3pace_domain_model_speaker')]
class Speaker extends AbstractEntity
{
    #[ORM\Column(type: 'string', length: 255)]
    protected string $name = '';

    #[ORM\Column(type: 'text', nullable: true)]
    protected string $bio = '';

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected string $company = '';

    #[ORM\ManyToOne(targetEntity: FileReference::class, cascade: ['persist', 'remove'])]
    protected ?FileReference $image = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    protected string $slug = '';

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBio(): string
    {
        return $this->bio;
    }

    public function setBio(string $bio): void
    {
        $this->bio = $bio;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    public function getImage(): ?FileReference
    {
        return $this->image;
    }

    public function setImage(?FileReference $image): void
    {
        $this->image = $image;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }
}

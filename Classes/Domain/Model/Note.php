<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\CMS\Extbase\Domain\Model\AbstractEntity;

#[ORM\Entity]
#[ORM\Table(name: 'tx_dt3pace_domain_model_note')]
class Note extends AbstractEntity
{
    #[ORM\Column(type: 'text')]
    protected string $noteText = '';

    #[ORM\ManyToOne(targetEntity: Session::class)]
    protected ?Session $session = null;

    #[ORM\ManyToOne(targetEntity: \TYPO3\CMS\Extbase\Domain\Model\FrontendUser::class)]
    protected ?\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user = null;

    public function getNoteText(): string
    {
        return $this->noteText;
    }

    public function setNoteText(string $noteText): void
    {
        $this->noteText = $noteText;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): void
    {
        $this->session = $session;
    }

    public function getUser(): ?\TYPO3\CMS\Extbase\Domain\Model\FrontendUser
    {
        return $this->user;
    }

    public function setUser(?\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user): void
    {
        $this->user = $user;
    }
}

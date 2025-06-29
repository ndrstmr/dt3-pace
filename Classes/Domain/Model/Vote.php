<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\CMS\Extbase\Domain\Model\AbstractEntity;
use Ndrstmr\Dt3Pace\Domain\Model\FrontendUser;

/**
 * Represents a single vote for a session.
 */
#[ORM\Entity]
#[ORM\Table(name: 'tx_dt3pace_domain_model_vote')]
class Vote extends AbstractEntity
{
    #[ORM\ManyToOne(targetEntity: Session::class)]
    protected ?Session $session = null;

    #[ORM\ManyToOne(targetEntity: FrontendUser::class)]
    protected ?FrontendUser $voter = null;

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): void
    {
        $this->session = $session;
    }

    public function getVoter(): ?FrontendUser
    {
        return $this->voter;
    }

    public function setVoter(?FrontendUser $voter): void
    {
        $this->voter = $voter;
    }
}

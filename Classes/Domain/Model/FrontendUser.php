<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\CMS\Extbase\Domain\Model\AbstractEntity;

#[ORM\Entity]
#[ORM\Table(name: 'fe_users')]
class FrontendUser extends AbstractEntity
{
    // Additional properties can be added if needed
}

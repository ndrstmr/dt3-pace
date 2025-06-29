<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Service;

use Ndrstmr\Dt3Pace\Domain\Model\FrontendUser;
use Ndrstmr\Dt3Pace\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Core\Context\Context;

class FrontendUserProvider
{
    public function __construct(
        private readonly FrontendUserRepository $frontendUserRepository,
        private readonly Context $context
    ) {
    }

    public function getCurrentFrontendUser(): ?FrontendUser
    {
        $uid = $this->context->getPropertyFromAspect('frontend.user', 'id', 0);
        \assert(is_int($uid));
        if ($uid === 0) {
            return null;
        }

        /** @var FrontendUser|null $frontendUser */
        $frontendUser = $this->frontendUserRepository->findByUid($uid);
        return $frontendUser;
    }
}

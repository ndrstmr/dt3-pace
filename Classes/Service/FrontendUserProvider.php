<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Service;

use Ndrstmr\Dt3Pace\Domain\Model\FrontendUser;
use Ndrstmr\Dt3Pace\Domain\Repository\FrontendUserRepository;

class FrontendUserProvider
{
    public function __construct(private readonly FrontendUserRepository $frontendUserRepository)
    {
    }

    public function getCurrentFrontendUser(): ?FrontendUser
    {
        $uid = (int)($GLOBALS['TSFE']->fe_user->user['uid'] ?? 0);
        if ($uid === 0) {
            return null;
        }

        /** @var FrontendUser|null $frontendUser */
        $frontendUser = $this->frontendUserRepository->findByUid($uid);
        return $frontendUser;
    }
}

<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Service\FrontendUserProvider;
use Ndrstmr\Dt3Pace\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\SecurityAspect;
use TYPO3\CMS\Core\Security\RequestToken;
use TYPO3\CMS\Core\Utility\GeneralUtility;

abstract class BaseAjaxController extends ActionController
{
    public function __construct(protected readonly FrontendUserProvider $frontendUserProvider)
    {
    }

    protected function getAuthenticatedUser(): ?FrontendUser
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $securityAspect = SecurityAspect::provideIn($context);
        if (!$securityAspect->getReceivedRequestToken() instanceof RequestToken) {
            return null;
        }

        return $this->frontendUserProvider->getCurrentFrontendUser();
    }
}

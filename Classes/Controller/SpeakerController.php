<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Controller;

use Ndrstmr\Dt3Pace\Domain\Model\Speaker;
use Ndrstmr\Dt3Pace\Domain\Repository\SpeakerRepository;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SpeakerController extends ActionController
{
    public function __construct(private readonly SpeakerRepository $speakerRepository)
    {
    }

    public function listAction(): void
    {
        $this->view->assign('speakers', $this->speakerRepository->findAll());
    }

    #[IgnoreValidation('speaker')]
    public function showAction(Speaker $speaker): void
    {
        $this->view->assign('speaker', $speaker);
    }
}

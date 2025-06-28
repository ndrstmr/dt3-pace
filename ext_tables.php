<?php
declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Ndrstmr\Dt3Pace\Controller\SchedulerController;

defined('TYPO3') or die();

ExtensionManagementUtility::addModule(
    'dt3pace',
    '',
    '',
    '',
    [
        'access' => 'user,group',
        'iconIdentifier' => 'actions-calendar',
        'labels' => 'LLL:EXT:dt3_pace/Resources/Private/Language/locallang_dt3pace.xlf:module.main',
    ]
);

ExtensionUtility::registerModule(
    'Ndrstmr.Dt3Pace',
    'dt3pace',
    'sessions',
    '',
    [],
    [
        'access' => 'user,group',
        'iconIdentifier' => 'content-table',
        'labels' => 'LLL:EXT:dt3_pace/Resources/Private/Language/locallang_dt3pace.xlf:module.sessions',
    ]
);

ExtensionUtility::registerModule(
    'Ndrstmr.Dt3Pace',
    'dt3pace',
    'speakers',
    '',
    [],
    [
        'access' => 'user,group',
        'iconIdentifier' => 'content-table',
        'labels' => 'LLL:EXT:dt3_pace/Resources/Private/Language/locallang_dt3pace.xlf:module.speakers',
    ]
);

ExtensionUtility::registerModule(
    'Ndrstmr.Dt3Pace',
    'dt3pace',
    'management',
    '',
    [],
    [
        'access' => 'user,group',
        'iconIdentifier' => 'content-table',
        'labels' => 'LLL:EXT:dt3_pace/Resources/Private/Language/locallang_dt3pace.xlf:module.management',
    ]
);

ExtensionUtility::registerModule(
    'Ndrstmr.Dt3Pace',
    'dt3pace',
    'scheduler',
    '',
    [SchedulerController::class => 'show,updateSessionSlot'],
    [
        'access' => 'user,group',
        'iconIdentifier' => 'actions-calendar',
        'labels' => 'LLL:EXT:dt3_pace/Resources/Private/Language/locallang_dt3pace.xlf:module.scheduler',
    ]
);

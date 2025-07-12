<?php
return [
    'dt3pace' => [
        'labels' => 'LLL:EXT:dt3_pace/Resources/Private/Language/locallang_dt3pace.xlf:module.main',
        'iconIdentifier' => 'actions-calendar',
        'access' => 'user,group',
    ],
    'dt3pace_sessions' => [
        'parent' => 'dt3pace',
        'access' => 'user,group',
        'iconIdentifier' => 'content-table',
        'labels' => 'LLL:EXT:dt3_pace/Resources/Private/Language/locallang_dt3pace.xlf:module.sessions',
        'extensionName' => 'Dt3Pace',
        'controllerActions' => [],
    ],
    'dt3pace_speakers' => [
        'parent' => 'dt3pace',
        'access' => 'user,group',
        'iconIdentifier' => 'content-table',
        'labels' => 'LLL:EXT:dt3_pace/Resources/Private/Language/locallang_dt3pace.xlf:module.speakers',
        'extensionName' => 'Dt3Pace',
        'controllerActions' => [],
    ],
    'dt3pace_management' => [
        'parent' => 'dt3pace',
        'access' => 'user,group',
        'iconIdentifier' => 'content-table',
        'labels' => 'LLL:EXT:dt3_pace/Resources/Private/Language/locallang_dt3pace.xlf:module.management',
        'extensionName' => 'Dt3Pace',
        'controllerActions' => [],
    ],
    'dt3pace_scheduler' => [
        'parent' => 'dt3pace',
        'access' => 'admin',
        'iconIdentifier' => 'actions-calendar',
        'labels' => 'LLL:EXT:dt3_pace/Resources/Private/Language/locallang_dt3pace.xlf:module.scheduler',
        'extensionName' => 'Dt3Pace',
        'controllerActions' => [
            \Ndrstmr\Dt3Pace\Controller\SchedulerController::class => [
                'show',
                'updateSessionSlot',
            ],
        ],
    ],
];

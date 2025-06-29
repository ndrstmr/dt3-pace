<?php
return [
    'ctrl' => [
        'title' => 'Session',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:dt3_pace/Resources/Public/Icons/tx_dt3pace_domain_model_session.svg',
    ],
    'interface' => [
        'showRecordFieldList' => 'title,slug,status,room,time_slot',
    ],
    'columns' => [
        'hidden' => [
            'label' => 'Hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'title' => [
            'label' => 'Title',
            'config' => [
                'type' => 'input',
                'required' => true,
            ],
        ],
        'slug' => [
            'label' => 'LLL:EXT:dt3_pace/Resources/Private/Language/locallang_db.xlf:tx_dt3pace_domain_model_session.slug',
            'config' => [
                'type' => 'slug',
                'generatorOptions' => [
                    'fields' => ['title'],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
            ],
        ],
        'description' => [
            'label' => 'Description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
            ],
        ],
        'status' => [
            'label' => 'LLL:EXT:dt3_pace/Resources/Private/Language/locallang_db.xlf:tx_dt3pace_domain_model_session.status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:dt3_pace/Resources/Private/Language/locallang_db.xlf:tx_dt3pace_domain_model_session.status.I.proposed', 'proposed'],
                    ['LLL:EXT:dt3_pace/Resources/Private/Language/locallang_db.xlf:tx_dt3pace_domain_model_session.status.I.scheduled', 'scheduled'],
                    ['LLL:EXT:dt3_pace/Resources/Private/Language/locallang_db.xlf:tx_dt3pace_domain_model_session.status.I.rejected', 'rejected'],
                ],
                'default' => 'proposed',
            ],
        ],
        'votes' => [
            'label' => 'Votes',
            'config' => [
                'type' => 'input',
                'eval' => 'int',
            ],
        ],
        'is_published' => [
            'label' => 'Published',
            'config' => [
                'type' => 'check',
            ],
        ],
        'proposer' => [
            'label' => 'Proposer',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
            ],
        ],
        'speakers' => [
            'label' => 'Speakers',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_dt3pace_domain_model_speaker',
                'MM' => 'tx_dt3pace_session_speaker_mm',
            ],
        ],
        'room' => [
            'label' => 'Room',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_dt3pace_domain_model_room',
            ],
        ],
        'track' => [
            'label' => 'Track',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_dt3pace_domain_model_track',
            ],
        ],
        'time_slot' => [
            'label' => 'Time slot',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_dt3pace_domain_model_timeslot',
            ],
        ],
        'slides' => [
            'label' => 'Slides',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'sys_file_reference',
                'foreign_field' => 'uid_foreign',
                'foreign_table_field' => 'tablenames',
                'foreign_match_fields' => [
                    'fieldname' => 'slides',
                ],
                'appearance' => [
                    'collapseAll' => true,
                    'useSortable' => false,
                    'headerThumbnail' => [
                        'field' => 'uid_local',
                        'height' => '64c',
                        'width' => '64c',
                    ],
                ],
                'filter' => [
                    [
                        'userFunc' => \TYPO3\CMS\Core\Resource\FileReferenceFilter::class . '::filterInlineChildren',
                    ],
                ],
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '--div--;Allgemein, hidden, title, slug, description, status, votes, is_published,'
                . '--div--;Relations, proposer, speakers, room, track, time_slot, slides',
        ],
    ],
];

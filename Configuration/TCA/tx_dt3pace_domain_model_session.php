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
        'description' => [
            'label' => 'Description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
            ],
        ],
        'status' => [
            'label' => 'Status',
            'config' => [
                'type' => 'input',
                'size' => 20,
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
    ],
    'types' => [
        '0' => ['showitem' => 'hidden, title, description, status, votes, is_published, proposer, speakers, room, track, time_slot'],
    ],
];

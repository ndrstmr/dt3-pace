<?php
return [
    'ctrl' => [
        'title' => 'Vote',
        'label' => 'uid',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:dt3_pace/Resources/Public/Icons/tx_dt3pace_domain_model_vote.svg',
    ],
    'interface' => [
        'showRecordFieldList' => 'session,voter',
    ],
    'columns' => [
        'hidden' => [
            'label' => 'Hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'session' => [
            'label' => 'Session',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_dt3pace_domain_model_session',
            ],
        ],
        'voter' => [
            'label' => 'Voter',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '--div--;Allgemein, hidden, session, voter',
        ],
    ],
];

<?php
return [
    'ctrl' => [
        'title' => 'Track',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:dt3_pace/Resources/Public/Icons/tx_dt3pace_domain_model_track.svg',
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
    ],
    'types' => [
        '0' => ['showitem' => 'hidden, title'],
    ],
];

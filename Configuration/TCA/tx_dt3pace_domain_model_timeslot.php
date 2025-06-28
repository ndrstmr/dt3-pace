<?php
return [
    'ctrl' => [
        'title' => 'Time Slot',
        'label' => 'start',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:dt3_pace/Resources/Public/Icons/tx_dt3pace_domain_model_timeslot.svg',
    ],
    'interface' => [
        'showRecordFieldList' => 'start,end',
    ],
    'columns' => [
        'hidden' => [
            'label' => 'Hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'start' => [
            'label' => 'Start',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
            ],
        ],
        'end' => [
            'label' => 'End',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
            ],
        ],
    ],
    'palettes' => [
        'times' => [
            'showitem' => 'start, end',
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '--div--;Allgemein, hidden, --palette--;;times',
        ],
    ],
];

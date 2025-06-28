<?php
return [
    'ctrl' => [
        'title' => 'Room',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:dt3_pace/Resources/Public/Icons/tx_dt3pace_domain_model_room.svg',
    ],
    'interface' => [
        'showRecordFieldList' => 'name,capacity',
    ],
    'columns' => [
        'hidden' => [
            'label' => 'Hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'name' => [
            'label' => 'Name',
            'config' => [
                'type' => 'input',
                'required' => true,
            ],
        ],
        'capacity' => [
            'label' => 'Capacity',
            'config' => [
                'type' => 'input',
                'eval' => 'int',
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '--div--;Allgemein, hidden, name, capacity',
        ],
    ],
];

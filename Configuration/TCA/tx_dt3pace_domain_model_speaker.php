<?php
return [
    'ctrl' => [
        'title' => 'Speaker',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:dt3_pace/Resources/Public/Icons/tx_dt3pace_domain_model_speaker.svg',
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
        'bio' => [
            'label' => 'Bio',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
            ],
        ],
        'company' => [
            'label' => 'Company',
            'config' => [
                'type' => 'input',
            ],
        ],
        'image' => [
            'label' => 'Image',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-media-types',
            ],
        ],
        'slug' => [
            'label' => 'Slug',
            'config' => [
                'type' => 'input',
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'hidden, name, bio, company, image, slug'],
    ],
];

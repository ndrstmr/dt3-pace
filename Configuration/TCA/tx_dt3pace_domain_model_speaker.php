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
    'interface' => [
        'showRecordFieldList' => 'name,company,slug',
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
                'type' => 'inline',
                'foreign_table' => 'sys_file_reference',
                'foreign_field' => 'uid_foreign',
                'foreign_table_field' => 'tablenames',
                'foreign_match_fields' => [
                    'fieldname' => 'image',
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
        'slug' => [
            'label' => 'Slug',
            'config' => [
                'type' => 'input',
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '--div--;Allgemein, hidden, name, company, slug, --div--;Details, bio, image',
        ],
    ],
];

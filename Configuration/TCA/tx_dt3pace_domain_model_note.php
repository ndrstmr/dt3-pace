<?php
return [
    'ctrl' => [
        'title' => 'Note',
        'label' => 'note_text',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'iconfile' => 'EXT:dt3_pace/Resources/Public/Icons/tx_dt3pace_domain_model_note.svg',
    ],
    'interface' => [
        'showRecordFieldList' => 'note_text,session,user',
    ],
    'columns' => [
        'note_text' => [
            'label' => 'Note Text',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
            ],
        ],
        'session' => [
            'label' => 'Session',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_dt3pace_domain_model_session',
                'foreign_table_where' => 'ORDER BY tx_dt3pace_domain_model_session.title',
            ],
        ],
        'user' => [
            'label' => 'User',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'foreign_table_where' => 'ORDER BY fe_users.username',
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => 'note_text,session,user',
        ],
    ],
];
<?php
declare(strict_types=1);

$EM_CONF[$_EXTKEY] = [
    'title' => 'PACE - Planning And Conference Engine',
    'description' => 'Conference management tools',
    'category' => 'module',
    'author' => 'DT3 Team',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99'
        ],
        'conflicts' => [],
        'suggests' => []
    ]
];

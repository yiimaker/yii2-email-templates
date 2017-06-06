<?php
return [
    'db' => require (__DIR__ . '/db.php'),

    'templateManager' => [
        'class' => \ymaker\email\templates\components\TemplateManager::class,
    ],
];
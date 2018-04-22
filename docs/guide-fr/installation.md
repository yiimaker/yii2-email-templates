L’installation
==============

## Réservoir le paquet du composer

Le meilleur moyen d’installer cette extension c’est par le [composer](http://getcomposer.org/download/).

Ou bien lancez

```
$ composer require yiimaker/yii2-email-templates
```

ou ajoutez

```
"yiimaker/yii2-email-templates": "~4.0"
````

pour la section `require` de votre `composer.json`.

## Configurer l’application

### Les migrations

```php
// console/config/main.php

'controllerMap' => [
    'migrate' => [
        'class' => yii\console\controllers\MigrateController::class,
        'migrationNamespaces' => [
           // ...
           'ymaker\email\templates\migrations',
        ],
    ],
],
```

### Backend module

Pour utiliser cette extension juste ajoutez le code suivant dans votre configuration de l’application:

```php
'modules' => [
    // ...
    'email-templates' => [
        'class' => \ymaker\email\templates\Module::class,
        'languageProvider' => [
            'class' => \motion\i18n\ConfigLanguageProvider::class,
            'languages' => [
                [
                    'locale' => 'en',
                    'label' => 'English',
                ],
                // ...
            ],
            'defaultLanguage' => [
                'locale' => 'en',
                'label' => 'English',
            ],
        ],
    ],
]
```

### Le manager du modèle de courriel

```php
'components' => [
    // ...
    'templateManager' => [
        'class' => \ymaker\email\templates\components\TemplateManager::class,
    ],
]
```

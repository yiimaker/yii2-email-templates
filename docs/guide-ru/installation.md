Установка
=========

## Получение с помощью Composer

Предпочтительный способ установки расширения через [composer](http://getcomposer.org/download/).

Для этого запустите

```
$ composer require yiimaker/yii2-email-templates
```

или добавьте

```
"yiimaker/yii2-email-templates": "~2.1"
````

в секцию `require` вашего `composer.json`.

## Настройка приложения

### Миграции

```php
// console/config/main.php

'controllerMap' => [
    'migrate' => [
         'migrationNamespaces' => [
            // ...
             'ymaker\email\templates\migrations',
         ],
    ],
],
```

### Backend модуль

Для использования расширения, просто добавьте этот код в конфигурацию вашего приложения:

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

### Менеджер шаблонов

```php
'components' => [
    // ...
    'templateManager' => [
        'class' => \ymaker\email\templates\components\TemplateManager::class,
    ],
]
```
Basic usage
===========

1) Configure module in backend part of your application
```php
'modules' => [
    // ...
    'email-templates' => [
        'class' => \ymaker\email\templates\Module::class,
        'languageProvider' => [
            'class' => \yii2deman\tools\i18n\ConfigLanguageProvider::class,
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
#### Configuration options
`languageProvider` - it's required configuration property uses for
intergrate a internationalization

`service` - it's not required configuration property uses for work with models
data in controller. You can use default database service `\ymaker\email\templates\services\DbService`
or implement another service. For this you should to implement a `\ymaker\email\templates\services\ServiceInterface`
basic interface.

2) Configure template manager
```php
'components' => [
    // ...
    'templateManager' => [
        'class' => \ymaker\email\templates\components\TemplateManager::class,
    ],
]
```
This component provide stack of methods for work with email templates in client code.
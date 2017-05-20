Basic usage
===========

1) Configure module in backend part of your application
```php
'modules' => [
    // ...
    'email-templates' => [
        'class' => \ymaker\email\templates\Module::class,
        'languageProvider' => [
            'class' => \ymaker\email\templates\providers\ConfigLanguageProvider::class,
            'languages' => [
                [
                    'locale' => 'en',
                    'title' => 'English',
                ],
            ],
            'defaultLanguage' => [
                'locale' => 'en',
                'title' => 'English',
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
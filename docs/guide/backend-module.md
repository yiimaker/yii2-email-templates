Backend module
==============

## Configuration options

### Language provider

This is a required configuration property that is used for i18n.

It supports database and configuration language providers. You can implement your language
provider if you need.

Configuration language provider example:

```php
'languageProvider' => [
    'class' => \motion\i18n\ConfigLanguageProvider::class,
    'languages' => [
        [
            'locale' => 'en',
            'label' => 'English',
        ],
        [
            'locale' => 'ru',
            'label' => 'Russian',
        ],
    ],
    'defaultLanguage' => [
        'locale' => 'en', // value should be exactly like in language property of your app config
        'label' => 'English',
    ],
],
```

Database language provider example:

```php
'languageProvider' => [
    'class' => \motion\i18n\DbLanguageProvider::class,
    'tableName' => 'app_language', // table name in database with languages
    'localeField' => 'locale', // field name in language table with locale
    'labelField' => 'title', // field name in language table with label
    'defaultField' => 'default', // flag name in language table it's default language
],
```

[Read more](https://github.com/motion/yii2-language-provider) about language provider.

### Service

It is not obligatory property that is used in controller to work with data.

You can use default email template service `\ymaker\email\templates\services\EmailTemplateService`
or implement another service, for this you should implement a basic interface `\ymaker\email\templates\services\ServiceInterface`.
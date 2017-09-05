Advanced usage
==============

Module configuration options
----------------------------

#### Language provider
It's required configuration property uses for intergrate a internationalization.

Supports database and configuration language providers. You can implement your language
provider.

Configuration language provider example
```php
'languageProvider' => [
    'class' => \yii2deman\tools\i18n\ConfigLanguageProvider::class,
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

Database language provider example
```php
'languageProvider' => [
    'class' => \yii2deman\tools\i18n\DbLanguageProvider::class,
    'tableName' => 'app_language', // table name in database with languages
    'localeField' => 'locale', // field name in language table with locale
    'labelField' => 'title', // field name in language table with label
    'defaultField' => 'default', // flag name in language table it's default language
],
```

[Read more](https://github.com/yii2deman/yii2deman-language-provider) about language provider.

#### Service
It's not required configuration property uses for work with
data layer in controller.

You can use default database service `\ymaker\email\templates\services\DbService`
or implement another service, for this you should to implement a `\ymaker\email\templates\services\ServiceInterface`
basic interface.

Template manager methods
------------------------

* `null|EmailTemplateModel getTemplate($key, $language = null)` - returns template by key and language
* `null|EmailTemplateModel[] getAllTemplates($key)` - returns templates on all languages
* `mixed getFirstOrDefault($key, $default = null)` - returns template on first founded language by key all default value
* `bool hasTemplate($key)` - check is template with current key exists

Gii generator
-------------

You can generate email templates with Gii!

For it you should to configure generator in your application config like the following
```php
'modules' => [
    'gii' => [
        // ...
        'generators' => [
            // ...
            'email-templates' => [
                'class' => \ymaker\email\templates\gii\Generator::class,
                'templates' => [
                    'default' => '@vendor/yiimaker/yii2-email-templates/src/gii/default',
                ],
            ],
        ],
    ],
],
```

Generator creates migration for inserting a email template to database table.
After generation you should to run `./yii migrate` command in console.
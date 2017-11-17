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

Template manager
----------------

You can get data to replace of keywords from some classes methods, application components, databases, widgets, etc.

##### Example of letter body
    
    ```
            {project-name}
    Dear {username}, thank you for buying products on our shop!
    
    Products you buying
    {products-table}
    
    For information about delivery you can {support-callcenter-link} or {support-email-link}.
    
    {goodbye-message}
    ```
    
##### Template parsing

    ```php
    // getting template by key
    
    /* @var string $productsTable HTML table of bought products */
    $productsTable = \app\modules\shop\widgets\BoughtProductsTable::widget([
        'buyerId' => Yii::$app->getUser()->id,
    ]);
    
    /* @var \app\components\Configuration $config Component with configuration from dashboard */
    $config = Yii::$app->get('config');
    
    $supportCallcenterLink = \yii\helpers\Html::a(
        \Yii::t('shop', 'call to us'),
        $config->supportCallcenterNumber
    );
    $supportEmailLink = \yii\helpers\Html::a(
        \Yii::t('shop', 'write to e-mail'),
        $config->supportEmailAddress
    );
    
    $template->parseBody([
        'project-name'              => \Yii::$app->name,
        'username'                  => \Yii::$app->getIdentity()->firstname,
        'products-table'            => $productsTable,
        'support-callcenter-link'   => $supportCallcenterLink,
        'support-email-link'        => $supportEmailLink,
        'goodbye-message'           => \app\bots\EmailBot::generateGoodbyeMessage(),
    ]);
    ```
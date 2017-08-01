Basic usage
===========

### 1. Configure module in backend part of your application
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
intergrate a internationalization.

[Read more](https://github.com/yii2deman/yii2deman-language-provider) about language provider.

`service` - it's not required configuration property uses for work with
data layer in controller. You can use default database service `\ymaker\email\templates\services\DbService`
or implement another service, for this you should to implement a `\ymaker\email\templates\services\ServiceInterface`
basic interface.

### 2. Configure template manager
```php
'components' => [
    // ...
    'templateManager' => [
        'class' => \ymaker\email\templates\components\TemplateManager::class,
    ],
]
```
This component provide stack of methods for work with email templates in client code.

#### Methods

* `null|EmailTemplateModel getTemplate($key, $language = null)` - returns template by key and language
* `null|EmailTemplateModel[] getAllTemplates($key)` - returns templates on all languages
* `mixed getFirstOrDefault($key, $default = null)` - returns template on first founded language by key all default value
* `bool hasTemplate($key)` - check is template with current key exists

### Usage example
1. Create template with keys accross your site dashboard

    ##### Key
    
    `register-notification` - this is unique key of this template for using in your code

    ##### Subject
    
    `Notification from {site-name}`
    
    In this example email subject has one keyword `{site-name}`
    
    ##### Body
    
    `Hello, {username}! Welcome to {site-name} :)`
    
    Email body has two keywords `{username}` and `{site-name}`.
    
    > All keys should be wrapped by `{}`.
    
2. Now you can get this template in your

    ```php
    $template = Yii::$app->get('templateManager')->getTemplate('register-notification')
    ```
    
    This method returns template model object.
    
3. Then you should to parse this template

    ```php
    $template->parseSubject([
       '{site-name}' => Yii::$app->name,
    ]);
 
    $template->parseBody([
       '{username}' => Yii::$app->getIdentity()->username,
       '{site-name}' => Yii::$app->name,
    ]);
    ```
    
    or use another method
    
    ```php
    $template->parse([
       'subject' => [
           'site-name' => Yii::$app->name,
       ],
       'body' => [
           'username' => Yii::$app->getIdentity()->username,
           'site-name' => Yii::$app->name,
       ],
    ]);
    ```
    
    this methods replace keys in template to real data.
    
4. Now you can use data of this template in your logic

    ```php
    Yii::$app->get('mailer')->compose()
        // ...
        ->setSubject($template->subject)
        ->setHtmlBody($template->body)
        // ...
    ```
    
### Gii generator
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
                    'default' => '@vendor/yiimaker/yii2-email-templates/src/gii/default'
                ],
            ],
        ],
    ],
],
```

Generator creates migration for inserting a email template to database table.
After generation you should to run `./yii migrate` command in console.
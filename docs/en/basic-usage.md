Basic usage
===========
> If you want use all features - read a [advanced usage](advanced-usage.md) guide.

#### Configure module in backend part of your application

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

#### Configure template manager

```php
'components' => [
    // ...
    'templateManager' => [
        'class' => \ymaker\email\templates\components\TemplateManager::class,
    ],
]
```
This component provide [stack of methods](advanced-usage.md#template-manager-methods) for work with email templates in client code.

Usage example
-------------

1. Create template with keys accross your site dashboard or Gii generator

    ##### Key
    
    `register-notification` - this is unique key of this template for using in your code

    ##### Subject
    
    `Notification from {site-name}`
    
    In this example email subject has one keyword `{site-name}`
    
    ##### Body
    
    `Hello, {username}! Welcome to {site-name} :)`
    
    Email body has two keywords `{username}` and `{site-name}`.
    
    > All keys should be wrapped by `{}`.
    
2. Now you can get this template in your code

    ```php
    $template = Yii::$app->get('templateManager')->getTemplate('register-notification');
    ```
    
    This method returns template model object.
    
3. Then you should to parse this template

    ```php
    $template->parseSubject([
       'site-name' => Yii::$app->name,
    ]);
 
    $template->parseBody([
       'username' => Yii::$app->getIdentity()->username,
       'site-name' => Yii::$app->name,
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
        ->setSubject($template->subject)
        ->setHtmlBody($template->body)
        // ...
    ```
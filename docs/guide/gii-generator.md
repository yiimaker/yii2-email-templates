Gii generator
=============

You can generate email templates with Gii!

For this you should configure generator in your application config like the following:

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

Generator creates migration for inserting an email template to database table.
After generation you should run `./yii migrate` command in console.

## Generator preview

![yii2 email templates](../img/gii.jpg "yii2 email templates")
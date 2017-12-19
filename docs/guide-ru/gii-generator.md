Gii генератор
=============

Вы можете создавать шаблоны писен через Gii!

Для этого вам необходимо настроить генератор модуля Gii в вашем конфиге приложения
как показанно ниже:

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

Генератор создаёт миграцию для добавления шаблона в таблицу базы данных.
После генерации вам нужно запустить комманду `./yii migrate` в консоли.

## Превью генератора

![yii2 email templates](../img/gii.jpg "yii2 email templates")
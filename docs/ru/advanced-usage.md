Продвинутое использование
=========================

Опции конфигурации модуля
-------------------------

#### Провайдер языков
It's required configuration property uses for intergrate a internationalization.
то обязательная опция, которая используется для внедрения мультиязычности.

Поддерживаются провайдер для базы данных и провайдер для настройки в конфигурации приложения.
Вы можете реализовать собственный провайдер языков.

Пример использования провайдера для настройки в конфиругации прилодения
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
        'locale' => 'en', // значение должно быть точно таким как в опции приложения language
        'label' => 'English',
    ],
],
```

Пример использования провайдера для базы данных
```php
'languageProvider' => [
    'class' => \yii2deman\tools\i18n\DbLanguageProvider::class,
    'tableName' => 'app_language', // название таблицы в БД с языками
    'localeField' => 'locale', // название поля в таблице с локалью языка
    'labelField' => 'title', // название поля в таблице с зоголовком языка
    'defaultField' => 'default', // название флага в таблице является ли язык стандартным
],
```

[Читайте больше](https://github.com/yii2deman/yii2deman-language-provider) о языковом провайдере.

#### Service
Это не обязательная опция, которыя используется в контроллере для работы с данными.

Вы можете использовать стандартный сервис для хранения данных в БД `\ymaker\email\templates\services\DbService`
или реализовать свой сервис со своей моделью хранения данных,
для этого вы должны реализовать базовый интерфейс - `\ymaker\email\templates\services\ServiceInterface`.

Методы менеджера шаблонов
-------------------------

* `null|EmailTemplateModel getTemplate($key, $language = null)` - позвращает шаблон по ключу и языку
* `null|EmailTemplateModel[] getAllTemplates($key)` - возвращает шаблоны на все языках
* `mixed getFirstOrDefault($key, $default = null)` - возбращает либо шаблон на первом попавшимся языке либо стандартное значение
* `bool hasTemplate($key)` - проверяет существует ли шаблон с заданым ключём

Gii генератор
-------------

Вы можете создавать шаблоны писен через Gii!

Для этого вам необходимо настроить генератор модуля Gii в вашем конфиге приложения
как показанно ниже 
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
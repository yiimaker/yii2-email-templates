Backend модуль
==============

## Опции для настройки

### Language provider

Это обязательная опция, которая используется для внедрения мультиязычности.

Поддерживаются провайдер для базы данных и провайдер для настройки в конфигурации приложения.
Вы можете реализовать собственный провайдер языков.

Пример использования провайдера для настройки в конфиругации приложения:

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
        'locale' => 'en', // значение должно быть точно таким как в опции приложения language
        'label' => 'English',
    ],
],
```

Пример использования провайдера для базы данных:

```php
'languageProvider' => [
    'class' => \motion\i18n\DbLanguageProvider::class,
    'tableName' => 'app_language', // название таблицы в БД с языками
    'localeField' => 'locale', // название поля в таблице с локалью языка
    'labelField' => 'title', // название поля в таблице с зоголовком языка
    'defaultField' => 'default', // название флага в таблице является ли язык стандартным
],
```

[Читайте больше](https://github.com/motion/yii2-language-provider) о языковом провайдере.

### Service

Это не обязательная опция, которыя используется в контроллере для работы с данными.

Вы можете использовать стандартный сервис для хранения данных в БД `\ymaker\email\templates\services\DbService`
или реализовать свой сервис со своей моделью хранения данных,
для этого вы должны реализовать базовый интерфейс - `\ymaker\email\templates\services\ServiceInterface`.
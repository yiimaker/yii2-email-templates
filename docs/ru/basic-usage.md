Использование
=============

### 1. Настройте модуль в backend части вашего приложения
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
#### Настраиваемые опции модуля
`languageProvider` - это обязательная опция, которая используется для
внедрения многоязычности.

[Читайте больше](https://github.com/yii2deman/yii2deman-language-provider) о языковом провайдере.

`service` - это не обязательная опция, которыя используется в контроллере для работы с данными.
Вы можете использовать стандартный сервис для хранения данных в БД `\ymaker\email\templates\services\DbService`
или реализовать свой сервис со своей моделью хранения данных,
для этого вы должны реализовать базовый интерфейс - `\ymaker\email\templates\services\ServiceInterface`.

### 2. При надобности настройте менеджер шаблонов
```php
'components' => [
    // ...
    'templateManager' => [
        'class' => \ymaker\email\templates\components\TemplateManager::class,
    ],
]
```
Этот компонент предоставляет набор методов для комфортной работы с шаблонами в вашем коде.

#### Описание методов

* `null|EmailTemplateModel getTemplate($key, $language = null)` - позвращает шаблон по ключу и языку
* `null|EmailTemplateModel[] getAllTemplates($key)` - возвращает шаблоны на все языках
* `mixed getFirstOrDefault($key, $default = null)` - возбращает либо шаблон на первом попавшимся языке либо стандартное значение
* `bool hasTemplate($key)` - проверяет существует ли шаблон с заданым ключём
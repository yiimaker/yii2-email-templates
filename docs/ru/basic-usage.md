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

### Пример использования
1. Создайте шаблон сообщения с помощью вашей админ-панели

    ##### Key
    
    `register-notification` - это уникальный ключ этого шаблона для использования в вашем коде

    ##### Subject
    
    `Notification from {site-name}`
    
    В данном примере тема сообщения имеет один ключ `{site-name}`
    
    ##### Body
    
    `Hello, {username}! Welcome to {site-name} :)`
    
    Тело сообщения имеет два ключа `{username}` и `{site-name}`.
    
    > Все ключи должны быть обёрнуты в символы `{}`.
    
2. Теперь вы можете получить этот шаблон в своём коде

    ```php
    $template = Yii::$app->get('templateManager')->getTemplate('register-notification')
    ```
    
    Этот метод возвращает объект модели шаблона.
    
3. Далее вам нужно заменить ключи реальными данными

    ```php
    $template->parseSubject([
       '{site-name}' => Yii::$app->name,
    ]);
 
    $template->parseBody([
       '{username}' => Yii::$app->getIdentity()->username,
       '{site-name}' => Yii::$app->name,
    ]);
    ```
    
    или используя более короткую запись
    
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
    
    эти методы заменяют ключи реальными данными в полученной модели.
    
4. Теперь вы можете использовать данные из модели в своей логике

    ```php
    Yii::$app->get('mailer')->compose()
        // ...
        ->setSubject($template->subject)
        ->setHtmlBody($template->body)
        // ...
    ```
    
### Gii генератор
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
                    'default' => '@vendor/yiimaker/yii2-email-templates/src/gii/default'
                ],
            ],
        ],
    ],
],
```

Генератор создаёт миграцию для добавления шаблона в таблицу базы данных.
После генерации вам нужно запустить комманду `./yii migrate` в консоли.
Использование
=============
> Если вы хотите использовать все возможности - прочтите [продвинутуе использование](advanced-usage.md).

#### Настройте модуль в backend части вашего приложения

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

#### Настройте менеджер шаблонов

```php
'components' => [
    // ...
    'templateManager' => [
        'class' => \ymaker\email\templates\components\TemplateManager::class,
    ],
]
```
Этот компонент предоставляет [набор методов](advanced-usage.md#Методы-менеджера-шаблонов) для комфортной работы с шаблонами в вашем коде.

Пример использования
--------------------

1. Создайте шаблон сообщения с помощью вашей админ-панели или генератора Gii

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
    $template = Yii::$app->get('templateManager')->getTemplate('register-notification');
    ```
    
    Этот метод возвращает объект модели шаблона.
    
3. Далее вам нужно заменить ключи реальными данными

    ```php
    $template->parseSubject([
       'site-name' => Yii::$app->name,
    ]);
 
    $template->parseBody([
       'username' => Yii::$app->getIdentity()->username,
       'site-name' => Yii::$app->name,
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
        ->setSubject($template->subject)
        ->setHtmlBody($template->body)
        // ...
    ```
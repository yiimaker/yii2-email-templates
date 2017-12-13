Базовое использование
=====================

1. Создайте шаблон сообщения с помощью админки или Gii генератора

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
    
        Этот метод возвращает модель шаблона.
    
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

L’utilisation de base
=====================

1. Créer  le modèle d’email avec les substituants en utilisant le Dashboard de votre site ou Gii générateur

    ##### La clé
    
    `register-notification` - c’est la clé unique de ce modèle pour l’utiliser dans votre code

    ##### Le sujet
    
    `Notification from {site-name}`
    
    Dans cet exemple le sujet du courriel a un substituant `{site-name}`
    
    ##### Le corps
    
    `Hello, {username}! Welcome to {site-name} :)`
    
    Le corps du courriel a deux substituants `{username}` et `{site-name}`.
    
    > Toutes les clés doivent être emballées par `{}`.
    
2. Maintenant vous pouvez obtenir ce modèle dans votre code

    ```php
    $template = Yii::$app->get('templateManager')->getTemplate('register-notification');
    ```
    
    Cette méthode retourne l’objet du modèle.
    
3. Puis il faut parser ce modèle

    ```php
    $template->parseSubject([
       'site-name' => Yii::$app->name,
    ]);
 
    $template->parseBody([
       'username' => Yii::$app->getIdentity()->username,
       'site-name' => Yii::$app->name,
    ]);
    ```
    
    ou utiliser une autre méthode
    
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
    
    ces méthodes remplacent les substituants dans le modèle par les données réelles.
    
4. Maintenant vous pouvez utiliser les données du modèle dans votre logique

    ```php
    Yii::$app->get('mailer')->compose()
        ->setSubject($template->subject)
        ->setHtmlBody($template->body)
        // ...
    ```

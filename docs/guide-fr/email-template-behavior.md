Le comportement du modèle d’email
=================================

Vous pouvez utiliser le comportement du modèle d’email pour l’adjonction du modèle d’email à votre ActiveRecord modèle.

## Un modèle

### La configuration

```php
// bootstrap.php

\Yii::$container->set(
    \ymaker\email\templates\repositories\EmailTemplatesRepositoryInterface::class,
    \ymaker\email\templates\repositories\EmailTemplatesRepository::class
);

// or config/main.php
`container` => [
    'singletons' => [
        // ...
        \ymaker\email\templates\repositories\EmailTemplatesRepositoryInterface::class =>
            \ymaker\email\templates\repositories\EmailTemplatesRepository::class,
    ],
],
```

```php
// ActiveRecord modèle

public function behaviours()
{
    return [
        // ...
        'emailTemplate' => \ymaker\email\templates\behaviors\EmailTemplateBehavior::class,
    ];
}
```

### L’utilisation

> Votre modèle doit contient l’attribut de la langue.
> Vous pouvez préciser ce nom d’attribut dans la `languageAttribute` propriété de configuration.
> Cette propriété est installé à `language` par défaut.

```php
$model = new ActiveRecordModel();

$model->letterSubject = 'Bienvenue!';
$model->letterBody = 'Bonjour, {username}! Bienvenue à ...';
$model->emailTemplateHint = 'Dans "body" vous pouvez utilizer {username} le substituant';

$model->save();
```

## Les modèles multiples dans un seul modèle

### La configuration

```php
// ActiveRecord modèle

public function behaviours()
{
    return [
        // ...
        'emailTemplateWelcome' => [
            'class' => \ymaker\email\templates\behaviors\EmailTemplateBehavior::class,
            'key' => 'welcome', // Le clé unique du modèle pour le modèle actuel
        ],
        'emailTemplateBye' => [
            'class' => \ymaker\email\templates\behaviors\EmailTemplateBehavior::class,
            'key' => 'bue', // Le clé unique du modèle pour le modèle actuel
        ],
    ];
}
```

### L’utilisation

1. Créer les accesseurs
```php
class ActiveRecordModel extends \yii\db\ActiveRecord
{
    public function behaviours() {...}
    
    /* Email template welcome */
    
    public function getWelcomeLetterSubject()
    {
        return $this->getBehaviour('emailTemplateWelcome')->letterSubject;
    }
    
    public function setWelcomeLetterSubject($subject)
    {
        $this->getBehaviour('emailTemplateWelcome')->letterSubject = $subject;
    }
    
    // getters and setters for `letterBody` and `emailTemplateHint`
    
    /* Email template bye */
    
    public function getByeLetterSubject()
    {
        return $this->getBehaviour('emailTemplateBye')->letterSubject;
    }
    
    public function setByeLetterSubject($subject)
    {
        $this->getBehaviour('emailTemplateBye')->letterSubject = $subject;
    }
    
    // getters and setters for `letterBody` and `emailTemplateHint`
}
```

2. L’utilisation
```php
$model = new ActiveRecordModel();

$model->welcomeLetterSubject = 'Bonjour, {username}!';
$model->welcomeLetterBody = 'Cher, {username} ...';

$model->byeLetterSubject = 'Salut, {username} :(';
$model->byeLetterBody = 'Ne quitte pas notre {site-name} ;(';

$model->save();
```

Le manager du modèle d’email
============================

## Configuration

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

## L’utilisation

Vous pouvez recevoir les données pour remplacer les substituants dans le formulaire
des méthodes des classes, des composants de l’application, des bases des données, des widgets, etc.

### L’exemple du courriel
    
```
        {project-name}
Chère {username}, nous vous remercions de votre commande!

La liste de vos produits inclut
{products-table}

Pour recevoir les infos sur la livraison vous pouvez {support-callcenter-link} ou {support-email-link}.

{goodbye-message}
```
    
### Le parsage du modèle d’email

```php
// getting template by key

/* @var string $productsTable HTML table of bought products */
$productsTable = \app\modules\shop\widgets\BoughtProductsTable::widget([
    'buyerId' => Yii::$app->getUser()->id,
]);

/* @var \app\components\Configuration $config Component with configuration from dashboard */
$config = Yii::$app->get('config');

$supportCallcenterLink = \yii\helpers\Html::a(
    \Yii::t('shop', 'call to us'),
    $config->supportCallcenterNumber
);
$supportEmailLink = \yii\helpers\Html::a(
    \Yii::t('shop', 'write to e-mail'),
    $config->supportEmailAddress
);

$template->parseBody([
    'project-name'              => \Yii::$app->name,
    'username'                  => \Yii::$app->getIdentity()->firstname,
    'products-table'            => $productsTable,
    'support-callcenter-link'   => $supportCallcenterLink,
    'support-email-link'        => $supportEmailLink,
    'goodbye-message'           => \app\bots\EmailBot::generateGoodbyeMessage(),
]);
```

## Les méthodes pour manager les modèles du courriel

| Le méthode                                | La description                                                            | Retourne                          |
|-------------------------------------------|---------------------------------------------------------------------------|-----------------------------------|
|`getTemplate($key, $language = null)`      |Retourne le modèle selon la clé  et la langue                              |`null` ou `EmailTemplateModel`     |
|`getAllTemplates($key)`                    |Retourne le modèle en toutes les langues                                   |`null` ou `EmailTemplateModel[]`   |
|`getFirstOrDefault($key, $default = null)` |Retourne le modèle dans la 1ère langue trouvée ou dans la valeur défaut    |`mixed`                            |
|`hasTemplate($key)`                        |Vérifie si le modèle avec la clé actuelle existe                           |`bool`                             |

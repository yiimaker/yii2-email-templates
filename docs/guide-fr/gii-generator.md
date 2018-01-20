Gii générator
=============

Vous pouvez générer le modèle d’email avec Gii!

Pour ça vous devez configurer le générateur dans votre app config comme le suivant:

> Si vous utilisez le modèle avancé d’application, mettez ce code dans le fichier `backend/config/main-local.php`
> ou `frontend/config/main-local.php`

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

Générateur crée les migrations pour insérer le modèle du courriel au tableau de la base des données.
Après la génération vous devez lancer la commande `./yii migrate` dans la console.

## L’aperçu du générateur

![yii2 email templates](../img/gii.jpg "yii2 email templates")
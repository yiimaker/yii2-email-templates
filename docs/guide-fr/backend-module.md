Backend module
==============

## Les options de configuration

### Le fournisseur langagier

C’est une option exigée qui est utilisée pour l’intégrer le i18n.

On supporte aussi le fournisseur pour la base des données et le fournisseur de configuration.
Vous pouvez réaliser votre propre fournisseur langagier.

L’exemple d’utilisation du fournisseur langagier:

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
        'locale' => 'en', // la valeur doit être exactement comme dans la propriété de la langue
        'label' => 'English',
    ],
],
```

L’exemple d’utilisation du fournisseur pour la base des données:

```php
'languageProvider' => [
    'class' => \motion\i18n\DbLanguageProvider::class,
    'tableName' => 'app_language', // table name in database with languages
    'localeField' => 'locale', // field name in language table with locale
    'labelField' => 'title', // field name in language table with label
    'defaultField' => 'default', // flag name in language table it's default language
],
```

[Lisez plus](https://github.com/motion/yii2-language-provider) du fournisseur langagier.

### Le service

Ce n’est pas une option exigée. Elle est utilisée pour travailler avec la couche de données dans le contrôleur.
Vous pouvez utiliser le défaut service du modèle d’email `\ymaker\email\templates\services\EmailTemplateService`
ou appliquez un autre service. Pour ça il faut appliquer l’interface de base `\ymaker\email\templates\services\ServiceInterface`.
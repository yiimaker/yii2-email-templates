Template manager
================

## Using

You can get data to replace placeholders from some classes methods, application components, databases, widgets, etc.

### Example of letter body
    
```
        {project-name}
Dear {username}, thank you for buying products on our shop!

Products you buying
{products-table}

For information about delivery you can {support-callcenter-link} or {support-email-link}.

{goodbye-message}
```
    
### Template parsing

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

## Template manager methods

| Method                                    | Description                                                           | Returns                           |
|-------------------------------------------|-----------------------------------------------------------------------|-----------------------------------|
|`getTemplate($key, $language = null)`      |Returns template by key and language                                   |`null` or `EmailTemplateModel`     |
|`getAllTemplates($key)`                    |Returns templates on all languages                                     |`null` or `EmailTemplateModel[]`   |
|`getFirstOrDefault($key, $default = null)` |Returns template on first founded language by key or default value     |`mixed`                            |
|`hasTemplate($key)`                        |Check whether template with current key exists                         |`bool`                             |

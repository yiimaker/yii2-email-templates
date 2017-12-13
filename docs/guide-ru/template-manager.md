Менеджер шаблонов
=================

## Использование

Вы можете брать данные для замены ключей в шаблоне из методов классов,
компонентов приложения, баз данных, виджетов и т.п.

### Пример письма
    
```
        {project-name}
Dear {username}, thank you for buying products on our shop!

Products you buying
{products-table}

For information about delivery you can {support-callcenter-link} or {support-email-link}.

{goodbye-message}
```
    
### Замена ключей данными

```php
// получение шаблона по ключу

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

## Методы менеджера шаблонов

| Метод                                     | Описание                                                                      | Возвращает                        |
|-------------------------------------------|-------------------------------------------------------------------------------|-----------------------------------|
|`getTemplate($key, $language = null)`      |позвращает шаблон по ключу и языку                                             |`null` или `EmailTemplateModel`    |
|`getAllTemplates($key)`                    |возвращает шаблоны на все языках                                               |`null` или `EmailTemplateModel[]`  |
|`getFirstOrDefault($key, $default = null)` |возбращает либо шаблон на первом попавшимся языке либо стандартное значение    |`mixed`                            |
|`hasTemplate($key)`                        |проверяет существует ли шаблон с заданым ключём                                |`bool`                             |
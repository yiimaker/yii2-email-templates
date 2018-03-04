Поведение email template 
========================

Вы можете использовать поведение email template чтобы добавить шаблоны писем в свои модели ActiveRecord.

## Один шаблон

### Настройка поведения

```php
// ActiveRecord модель

public function behaviours()
{
    return [
        // ...
        'emailTemplate' => \ymaker\email\templates\behaviors\EmailTemplateBehavior::class,
    ];
}
```

### Использование

> Ваша модель должна содержать атррибут для языка. Вы можете указать имя этого аттрибута
в свойстве конфигурации `languageAttribute`. По умолчанию это свойство установлено в `language`.

```php
$model = new ActiveRecordModel();

$model->letterSubject = 'Добро пожаловать!';
$model->letterBody = 'Здравствуйте, {username}! Добро пожаловать на ...';
$model->emailTemplateHint = 'В "body" вы можете использовать ключевое слово {username}';

$model->save();
```

## Несколько шаблонов в одной модели

### Настройка

```php
// ActiveRecord модель

public function behaviours()
{
    return [
        // ...
        'emailTemplateWelcome' => [
            'class' => \ymaker\email\templates\behaviors\EmailTemplateBehavior::class,
            'key' => 'welcome', // уникальный ключ шаблона для текущей модели
        ],
        'emailTemplateBye' => [
            'class' => \ymaker\email\templates\behaviors\EmailTemplateBehavior::class,
            'key' => 'bue', // уникальный ключ шаблона для текущей модели
        ],
    ];
}
```

### Использование

1. Создание геттеров и сеттеров
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

2. Использование
```php
$model = new ActiveRecordModel();

$model->welcomeLetterSubject = 'Здравствуйте, {username}!';
$model->welcomeLetterBody = 'Дорогой, {username} ...';

$model->byeLetterSubject = 'Прощайте, {username} :(';
$model->byeLetterBody = 'Не покидайте наш {site-name} ;(';

$model->save();
```

<p align="center">
    <a href="https://github.com/yiimaker" target="_blank">
        <img src="https://avatars1.githubusercontent.com/u/24204902" height="100px">
    </a>
    <h1 align="center">Email templates module</h1>
    <br>
</p>

Extension for creating email templates and managing by using your site dashboard.
You can create email templates with CRUD module in your backend or Gii generator.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Build Status](https://travis-ci.org/yiimaker/yii2-email-templates.svg?branch=master)](https://travis-ci.org/yiimaker/yii2-email-templates)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yiimaker/yii2-email-templates/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yiimaker/yii2-email-templates/?branch=master)
[![Total Downloads](https://poser.pugx.org/yiimaker/yii2-email-templates/downloads)](https://packagist.org/packages/yiimaker/yii2-email-templates)
[![Latest Stable Version](https://poser.pugx.org/yiimaker/yii2-email-templates/v/stable)](CHANGELOG.md)
[![Latest Unstable Version](https://poser.pugx.org/yiimaker/yii2-email-templates/v/unstable)](CHANGELOG.md)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ composer require yiimaker/yii2-email-templates
```

or add

```
"yiimaker/yii2-email-templates": "~3.0"
```

to the `require` section of your `composer.json`.

Usage
-----

1. Create template with placeholders using your site dashboard or Gii generator

    ##### Key
    
    `register-notification` - this is unique key of this template for using in your code

    ##### Subject
    
    `Notification from {site-name}`
    
    In this example email subject has one placeholder `{site-name}`
    
    ##### Body
    
    `Hello, {username}! Welcome to {site-name} :)`
    
    Email body has two placeholders: `{username}` and `{site-name}`.
    
    > All keys should be wrapped by `{}`.
    
2. Now you can get this template in your code

    ```php
    $template = Yii::$app->get('templateManager')->getTemplate('register-notification');
    ```
    
    This method returns a template model object.
    
3. Then you should parse this template

    ```php
    $template->parseSubject([
       'site-name' => Yii::$app->name,
    ]);
 
    $template->parseBody([
       'username' => Yii::$app->getIdentity()->username,
       'site-name' => Yii::$app->name,
    ]);
    ```
    
    or use another method
    
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
    
    this methods replace placeholders in template with real data.
    
4. Now you can use data of this template in your logic

    ```php
    Yii::$app->get('mailer')->compose()
        ->setSubject($template->subject)
        ->setHtmlBody($template->body)
        // ...
    ```

Tests
-----
You can run tests with composer command

```
$ composer test
```

or using following command

```
$ codecept build && codecept run
```

Contributing
------------
For information about contributing please read [CONTRIBUTING.md](CONTRIBUTING.md).

License
-------
[![License](https://poser.pugx.org/yiimaker/yii2-email-templates/license)](LICENSE)

This project is released under the terms of the BSD-3-Clause [license](LICENSE).

Copyright (c) 2017, Yii Maker

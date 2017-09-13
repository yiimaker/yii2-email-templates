<p align="center">
    <a href="https://github.com/yiimaker" target="_blank">
        <img src="https://avatars1.githubusercontent.com/u/24204902" height="100px">
    </a>
    <h1 align="center">Email templates module</h1>
    <br>
</p>

Extension for creating of email templates and manage accross your site dashboard.
You can create email templates with CRUD module in your backend or Gii generator.

[![Build Status](https://travis-ci.org/yiimaker/yii2-email-templates.svg?branch=master)](https://travis-ci.org/yiimaker/yii2-email-templates)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yiimaker/yii2-email-templates/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yiimaker/yii2-email-templates/?branch=master)
[![Total Downloads](https://poser.pugx.org/yiimaker/yii2-email-templates/downloads)](https://packagist.org/packages/yiimaker/yii2-email-templates)
[![Latest Stable Version](https://poser.pugx.org/yiimaker/yii2-email-templates/v/stable)](CHANGELOG.md)
[![Latest Unstable Version](https://poser.pugx.org/yiimaker/yii2-email-templates/v/unstable)](CHANGELOG.md)

Installation
------------
#### Install package
Run command
```
composer require yiimaker/yii2-email-templates
```
or add
```json
"yiimaker/yii2-email-templates": "~2.1"
```
to the require section of your composer.json.

#### Apply migrations
```
./yii migrate --migrationPath=@vendor/yiimaker/yii2-email-templates/src/migrations
```

Usage
-----
* [(EN) Basic usage](docs/en/basic-usage.md)
* [(RU) Базовое использование](docs/ru/basic-usage.md)
* [(EN) Advanced usage](docs/en/advanced-usage.md)
* [(RU) Продвинутое использование](docs/ru/advanced-usage.md)

License
-------
[![License](https://poser.pugx.org/yiimaker/yii2-email-templates/license)](LICENSE``)

This project is released under the terms of the BSD-3-Clause [license](LICENSE).

Copyright (c) 2017, Yii Maker

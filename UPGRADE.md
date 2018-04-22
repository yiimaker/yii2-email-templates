Upgrading Instructions
======================

This file contains the upgrade notes. These notes highlight changes that could break your
application when you upgrade the package from one version to another.

Upgrade from 3.x to 4.x
-----------------------

* Moved entities from `ymaker\email\tempaltes\models\entities` namespace to `ymaker\email\tempaltes\entities`

* Moved `yiisoft/yii2-bootstrap`, `vova07/yii2-imperavi-widget` packages to suggesting

* Changed minimum Yii version from `^2.0.0` to `^2.0.13`

* Changed minimum `motion/yii2-language-provider` version from `~1.0.` to `~2.1`

* Removed unused dev packages `codeception/verify` and `codeception/specify`

* Removed `ymaker\email\templates\helpers\LanguageHelper` class. Use `motion\i18n\helpers\LanguageHelper` instead

* Removed `ymaker\email\templates\Module::$service` property. Use `ymaker\email\templates\Module::$repository` instead

* Removed `ymaker\email\templates\components\TemplateManager::getFirstOrDefault()` method

* Created `ymaker\email\templates\repositories\EmailTemplatesRepositoryInterface` and `ymaker\email\templates\repositories\EmailTemplatesRepositoryInterface`
instead of `ymaker\email\templates\services\ServiceInterface` and `ymaker\email\templates\services\EmailtemplateService`

* Using `yiimaker/yii2-translatable` instead of `creocoder/yii2-translateable`

Upgrade from 2.x to 3.x
-----------------------

* Language provider package changed from `yii2deman/yii2deman-language-provider` to `motion/yii2-language-provider`.
You must updates language provider configuration in backend module config.

* Changed API of `ymaker\email\templates\services\ServiceInterface` interface.

* Changed API of `ymaker\email\templates\controllers\DefaultController` controller.

* Created `ymaker\email\templates\services\EmailTemplatesService`
instead of `ymaker\email\templates\services\DbService`.

* Removed `ymaker\email\templates\widgets\LanguagesList` widget.

* Migrations for creation of email template entities has been united.

* Renamed `_serivice` and `_languageProvider` properties to `service`, `languageProvider` in backend module.

* Renamed `_service` property to `service` in default controller.

* Changed minimum `vova07/yii2-imperavi-widget` package version from `~1.3.1` to `~2.0`.

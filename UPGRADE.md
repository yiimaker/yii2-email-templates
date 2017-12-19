Upgrading Instructions
======================

This file contains the upgrade notes. These notes highlight changes that could break your
application when you upgrade the package from one version to another.

Upgrade from 2.1.0 to 3.0.0
---------------------------

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
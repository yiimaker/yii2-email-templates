Email Templates Module Change Log
---------------------------------

4.1.2 Under development
-----------------------
* Fix: Deprecation warnings in unit tests for Gii generator (greeflas)

4.1.1 August 10, 2019
---------------------
* Chg: Change `yiisoft/yii2-gii` version from `~2.0.0` to `~2.1.0` (greeflas)
* Chg: Change `codeception/codeception` version from `~2.0` to `~3.0` (greeflas)
* Chg: Update dependencies in composer.lock (greeflas)

4.1.0 June 24, 2018
-------------------
* Enh #24: Gii generator: adds default value to the hint field (Geoffry304, greeflas)
* Enh #25: Gii generator: adds insert command for each language in migration file (Geoffry304, greelfas)
* Fix: Code style fixes and updates (greeflas)

4.0.1 May 23, 2018
------------------
* Chg: Changed minimum `yiimaker/yii2-translatable` from `~1.0` to `~1.0.1` (greeflas)

4.0.0 April 22, 2018
--------------------
* Enh: Inject repository object to template manager (greeflas)
* Enh: Inject repository object to email template behavior (greeflas)
* Chg: Changed minimum Yii version from `^2.0.0` to `^2.0.13` (greeflas)
* Chg: Changed minimum `motion/yii2-language-provider` version from `~1.0` to `~2.1` (greeflas)
* Chg: Using `yiimaker/yii2-translatable` instead of `creocoder/yii2-translateable` (greeflas)
* Chg: Moved `yiisoft/yii2-bootstrap`, `vova07/yii2-imperavi-widget` packages to suggesting (greeflas)
* Chg: Removed `ymaker\email\templates\helpers\LanguageHelper` helper (greeflas)
* Chg: Created repository class for email template entity
* Fix: Removed unused dev packages `codeception/verify` and `codeception/specify` (greeflas)
* Fix: Some fixes in files for unit tests (greeflas)
* Fix: Fixed bugs in migration (greeflas)

3.0.1 January 22, 2018
----------------------
Fix: Fixes bugs in migration (greeflas, philippfrenzel)

3.0.0 December 22, 2017
-----------------------
* Enh: Improved error handling (greeflas)
* Enh: Improved UX/UI in backend views (greeflas)
* Enh: Ability to work with all translation models in one request (greeflas)
* Enh: Created behavior for appending of email templates to ActiveRecord models (greeflas)
* Enh: Add namespace for migration (greeflas)
* Chg: Changed language provider package to `motion/yii2-language-provider` (greeflas, klipilin)

2.1.0 September 13, 2017
------------------------
* Enh: Updates errors handler(greeflas)
* Enh: Refactored DbService (greeflas)
* Fix: Bug with errors variable in create action on default controller (greeflas, AjithLalps)

2.0.0 September 11, 2017
------------------------

* Enh: Adds hint with default translation on template translation view (greeflas)
* Enh: Improves OOP code style (greeflas)
* Enh: Splitting a docs into two parts (greeflas)
* Enh: Adds tests for Gii generator (greeflas)
* Fix: Bug with `hint` field in new template translations (greeflas, AjithLalps)
* Fix: Translation category in `LanguagesList` widget (greeflas)

1.1.1 August 15, 2017
---------------------
* Fix: Multi-language support (greeflas, failhell)

1.1.0 August 1, 2017
--------------------
* Enh: Adds Gii generator for email templates (greeflas)

1.0.2 July 27, 2017
-------------------
* Fix: Bug with updating (greeflas)

1.0.1 June 22, 2017
-------------------
* Fix: Composer package version (greeflas)

1.0.0 June 14, 2017
-------------------
* Initial release (greeflas)

Development started March 31, 2017
---------------------------------

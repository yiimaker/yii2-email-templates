<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017-2019 Yii Maker
 * @license BSD 3-Clause License
 */

echo $form->field($generator, 'key')->textInput(['autofocus' => true]);
echo $form->field($generator, 'subject');
echo $form->field($generator, 'body')->textarea();
echo $form->field($generator, 'hint')->textInput();
echo $form->field($generator, 'migrationName')->hiddenInput();

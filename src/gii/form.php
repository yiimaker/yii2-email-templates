<?php

/**
 * Renders form for Gii generator.
 *
 * @var \yii\widgets\ActiveForm $form
 * @var \ymaker\email\templates\gii\Generator $generator
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.1
 */

echo $form->field($generator, 'key')->textInput(['autofocus' => true]);
echo $form->field($generator, 'subject');
echo $form->field($generator, 'body')->textarea();
echo $form->field($generator, 'hint')->textInput(['value' => 'All tokens wrapped in {} will be replaced by real data']);
echo $form->field($generator, 'migrationName')->hiddenInput();

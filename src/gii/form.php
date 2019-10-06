<?php
/* @var \ymaker\email\templates\gii\Generator $generator */

echo $form->field($generator, 'key')->textInput(['autofocus' => true]);
echo $form->field($generator, 'subject');
echo $form->field($generator, 'body')->textarea();
echo $form->field($generator, 'hint')->textInput();
echo $form->field($generator, 'migrationName')->hiddenInput();

<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ymaker\email\templates\Module as TemplatesModule;

/**
 * View file for CRUD backend controller
 *
 * @var \ymaker\email\templates\models\entities\EmailTemplate $template
 * @var \ymaker\email\templates\models\entities\EmailTemplateTranslation $translation
 * @var array $errors
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */

\yii\bootstrap\BootstrapAsset::register($this);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($errors)): ?>
                <?php foreach ($errors as $fieldErrors): ?>
                    <?php foreach ($fieldErrors as $error): ?>
                        <?= Alert::widget([
                            'body' => $error,
                            'options' => [
                                'class' => 'alert-danger'
                            ],
                        ]) ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="col-md-12">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->field($template, 'key') ?>
            <?= $form->field($translation, 'subject') ?>
            <?= $form->field($translation, 'body') ?>
            <?= $form->field($translation, 'hint') ?>
            <?= Html::submitButton(
                TemplatesModule::t('Create'),
                ['class' => 'btn btn-success']
            ) ?>
            <?php $form->end() ?>
        </div>
    </div>
</div>

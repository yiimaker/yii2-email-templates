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
use ymaker\email\templates\widgets\LanguagesList;
use vova07\imperavi\Widget as ImperaviRedactor;

/**
 * View file for CRUD backend controller.
 *
 * @var \ymaker\email\templates\models\entities\EmailTemplate $template
 * @var \ymaker\email\templates\models\entities\EmailTemplateTranslation $translation
 * @var \ymaker\email\templates\models\entities\EmailTemplateTranslation $defaultTranslation
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
            <h1>
                <?= TemplatesModule::t('Email templates') ?>
                <small><?= TemplatesModule::t('update template') ?></small>
                <div class="pull-right">
                    <?= LanguagesList::widget(['currentLanguage' => $translation->language]) ?>
                </div>
            </h1>
        </div>
        <div class="clearfix"></div>
        <hr>
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
            <?= $form->field($template, 'key')
                ->textInput(['disabled' => true]) ?>
            <?= $form->field($translation, 'subject')
                ->hint($defaultTranslation->getAttributeHint('subject')) ?>
            <?= $form->field($translation, 'body')
                ->widget(ImperaviRedactor::class)
                ->hint($defaultTranslation->getAttributeHint('body')) ?>
            <?= $form->field($translation, 'hint')
                ->textInput(['disabled' => !$translation->getIsNewRecord()]) ?>
            <?= $form->field($translation, 'templateId')
                ->hiddenInput()
                ->label(false) ?>
            <?= $form->field($translation, 'language')
                ->hiddenInput()
                ->label(false) ?>
            <?= Html::submitButton(
                TemplatesModule::t('Save'),
                ['class' => 'btn btn-success']
            ) ?>
            <?php $form->end() ?>
        </div>
        <?= $this->render('_issue-message') ?>
    </div>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ymaker\email\templates\Module as TemplatesModule;
use motion\i18n\helpers\LanguageHelper;
use vova07\imperavi\Widget as ImperaviRedactor;

/**
 * View file for CRUD backend controller.
 *
 * @var \yii\web\View $this
 * @var \ymaker\email\templates\entities\EmailTemplate $model
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */

$this->params['breadcrumbs'][] = [
    'label' => TemplatesModule::t('Email templates list'),
    'url' => ['/email-templates/default/index'],
];
$this->params['breadcrumbs'][] = TemplatesModule::t('Update email template - {key}', [
    'key' => $model->key,
]);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>
                <?= TemplatesModule::t('Email templates') ?>
                <small><?= TemplatesModule::t('update template') ?></small>
            </h1>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="col-md-12">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'key')
                ->textInput(['disabled' => true]) ?>
            <?php foreach (LanguageHelper::getInstance()->getLocales() as $language): ?>
                <?php $translation = $model->getTranslation($language) ?>
                <?= $form->field($translation, 'subject')
                    ->textInput() ?>
                <?php if (class_exists(ImperaviRedactor::class)): ?>
                    <?= $form->field($translation, 'body')
                        ->widget(ImperaviRedactor::class) ?>
                <?php else: ?>
                    <?= $form->field($translation, 'body')->textarea() ?>
                <?php endif; ?>
                <?= $form->field($translation, 'hint')
                    ->textInput(['disabled' => true]) ?>
            <?php endforeach ?>
            <?= Html::submitButton(
                TemplatesModule::t('Save'),
                ['class' => 'btn btn-success']
            ) ?>
            <?php $form->end() ?>
        </div>
        <?= $this->render('_issue-message') ?>
    </div>
</div>

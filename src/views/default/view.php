<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

use yii\helpers\Html;
use yii\helpers\Url;
use ymaker\email\templates\Module as TemplatesModule;
use ymaker\email\templates\widgets\LanguagesList;

/**
 * View file for CRUD backend controller.
 *
 * @@var \ymaker\email\templates\models\entities\EmailTemplate $template
 * @var \ymaker\email\templates\models\entities\EmailTemplateTranslation $translation
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
                <small><?= TemplatesModule::t('view template') ?></small>
            </h1>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="col-md-12">
            <div class="pull-left">
                <?= LanguagesList::widget(['currentLanguage' => $translation->language]) ?>
            </div>
            <div class="pull-right">
                <?= Html::a(
                TemplatesModule::t('Update'),
                Url::toRoute(['update', 'id' => $template->id, 'lang' => $translation->language]),
                ['class' => 'btn btn-warning']
                ) ?>
                <?= Html::a(
                TemplatesModule::t('Delete'),
                Url::toRoute(['delete', 'id' => $template->id]),
                ['class' => 'btn btn-danger']
                ) ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="col-md-12">
            <dl class="dl-horizontal">
                <dt>
                    <?= TemplatesModule::t('Key') ?>
                </dt>
                <dd>
                    <?= $template->key ?>
                </dd>
                <dt>
                    <?= TemplatesModule::t('Subject') ?>
                </dt>
                <dd>
                    <?= $translation->subject ?>
                </dd>
                <dt>
                    <?= TemplatesModule::t('Body') ?>
                </dt>
                <dd>
                    <?= $translation->body ?>
                </dd>
                <dt>
                    <?= TemplatesModule::t('Hint') ?>
                </dt>
                <dd>
                    <?= $translation->hint ?>
                </dd>
            </dl>
        </div>
        <?= $this->render('_issue-message') ?>
    </div>
</div>

<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use ymaker\email\templates\Module as TemplatesModule;

/**
 * View file for CRUD backend controller.
 *
 * @var \yii\web\View $this
 * @var \ymaker\email\templates\models\entities\EmailTemplate $model
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */

$this->params['breadcrumbs'][] = [
    'label' => TemplatesModule::t('Email templates list'),
    'url' => ['/email-templates/default/index'],
];
$this->params['breadcrumbs'][] = TemplatesModule::t('email template - {key}', [
    'key' => $model->key,
]);

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
            <div class="pull-right">
                <?= Html::a(
                    TemplatesModule::t('Update'),
                    Url::toRoute(['update', 'id' => $model->id]),
                    ['class' => 'btn btn-warning']
                ) ?>
                <?= Html::a(
                    TemplatesModule::t('Delete'),
                    Url::toRoute(['delete', 'id' => $model->id]),
                    ['class' => 'btn btn-danger']
                ) ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="col-md-12">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'key',
                    'subject',
                    'body:html',
                    'hint',
                ],
            ]) ?>
        </div>
        <?= $this->render('_issue-message') ?>
    </div>
</div>

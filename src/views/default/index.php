<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use ymaker\email\templates\Module as TemplatesModule;

/**
 * View file for CRUD backend controller.
 *
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */

$session = Yii::$app->getSession();
?>
<div class="container">
    <div class="row">
    <?php if ($session->hasFlash('yii2-email-templates')): ?>
        <div class="col-md-12">
            <div class="alert alert-success"><?= $session->getFlash('yii2-email-templates') ?></div>
        </div>
    <?php endif; ?>
        <div class="col-md-12">
            <h1>
                <?= TemplatesModule::t('Email templates') ?>
                <small><?= TemplatesModule::t('list of templates') ?></small>
                <?= Html::a(
                    TemplatesModule::t('Create template'),
                    Url::toRoute(['create']),
                    ['class' => 'btn btn-success pull-right']
                ) ?>
            </h1>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="col-md-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => SerialColumn::class],
                    'key',
                    ['class' => ActionColumn::class]
                ],
            ]) ?>
        </div>
        <?= $this->render('_issue-message') ?>
    </div>
</div>

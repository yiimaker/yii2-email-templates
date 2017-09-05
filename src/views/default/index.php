<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

use yii\grid\ActionColumn;
use yii\grid\GridView;
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

\yii\bootstrap\BootstrapAsset::register($this);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= Html::a(
                        TemplatesModule::t('Create template'),
                        Url::toRoute(['create']),
                        ['class' => 'btn btn-success']
                    ) ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'key',
                    ['class' => ActionColumn::class]
                ],
            ]) ?>
        </div>
    </div>
</div>

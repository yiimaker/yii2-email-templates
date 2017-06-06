<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var array $languages
 * 
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */

\yii\bootstrap\BootstrapPluginAsset::register($this);
?>
<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button"
            id="languages" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <?= Yii::t('email-templates', 'Language') ?>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="languages">
        <?php foreach ($languages as $language): ?>
            <li>
                <?= Html::a($language['label'], Url::current(['lang' => $language['locale']])) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

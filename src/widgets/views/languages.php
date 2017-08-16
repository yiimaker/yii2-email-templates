<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

/**
 * View file for language list widget.
 *
 * @var \yii\web\View $this
 * @var array $languages
 * @var null|string $currentLangLabel
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */

use yii\helpers\Html;
use yii\helpers\Url;

\yii\bootstrap\BootstrapPluginAsset::register($this);
?>
<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="email-template-languages"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="true">
        <?php if (!empty($currentLangLabel)): ?>
            <?= $currentLangLabel ?>
        <?php else: ?>
            <?= Yii::t('email-templates', 'Language') ?>
        <?php endif; ?>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="email-template-languages">
        <?php foreach ($languages as $language): ?>
            <li>
                <?= Html::a($language['label'], Url::current(['lang' => $language['locale']])) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

use ymaker\email\templates\Module as TemplatesModule;

/**
 * Partial view file with message for developers.
 *
 * @var \yii\web\View $this
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 3.0
 */
?>
<?php if (YII_ENV_DEV): ?>
    <div class="clearfix"></div>
    <hr>
    <div class="col-md-12">
        <p class="text-warning">
            <span class="glyphicon glyphicon-alert"></span>
            Found a bug?
            <a href="<?= TemplatesModule::getIssueUrl() ?>" target="_blank">Tell about it</a>
            to the extension developer.
        </p>
    </div>
<?php endif ?>

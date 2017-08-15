<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\tests\fixtures;

use yii\test\ActiveFixture;
use ymaker\email\templates\models\entities\EmailTemplateTranslation;

/**
 * Fixure for [[EmailTemplateTranslation]] model.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class EmailTemplateTranslationFixture extends ActiveFixture
{
    /**
     * @inheritdoc
     */
    public $modelClass = EmailTemplateTranslation::class;
    /**
     * @inheritdoc
     */
    public $dataFile = '@data/email-template-translations.php';
    /**
     * @inheritdoc
     */
    public $depends = [
        EmailTemplateFixture::class,
    ];
}

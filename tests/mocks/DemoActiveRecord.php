<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017-2019 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\tests\mocks;

use yii\db\ActiveRecord;

/**
 * This is demo ActiveRecord model.
 *
 * @property int    $id
 * @property string $letterSubject
 * @property string $letterBody
 * @property string $emailTemplateHint
 *
 * @author Volodymyr Kupriienko <vldmr.kuprienko@gmail.com>
 * @since 3.0
 */
class DemoActiveRecord extends ActiveRecord
{
    /**
     * @var array
     */
    public static $behaviors = [];
    /**
     * @var string
     */
    public $language = 'en';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'demo';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return self::$behaviors;
    }
}

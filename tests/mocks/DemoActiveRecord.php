<?php

namespace ymaker\email\templates\tests\mocks;

use yii\db\ActiveRecord;

/**
 * This is demo ActiveRecord model.
 *
 * @property int $id
 *
 * @property string $subject
 * @property string $body
 * @property string $hint
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
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
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'demo';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return self::$behaviors;
    }
}

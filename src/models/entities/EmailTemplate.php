<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\models\entities;

use Yii;
use yii\db\ActiveRecord;
use ymaker\email\templates\queries\EmailTemplateQuery;
use creocoder\translateable\TranslateableBehavior;

/**
 * This is the model class for table "{{%email_template}}".
 *
 * @property int $id
 * @property string $key
 *
 * @property EmailTemplateTranslation[] $translations
 *
 * @method EmailTemplateTranslation getTranslation($language = null)
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class EmailTemplate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email_template}}';
    }

    /**
     * @inheritdoc
     * @return EmailTemplateQuery the newly created [[EmailTemplateQuery]] instance.
     */
    public static function find()
    {
        return Yii::createObject(EmailTemplateQuery::class, [get_called_class()]);
    }

    /**
     * Find model ID by key.
     *
     * @param string $key Model key.
     * @return false|null|string
     */
    public static function findId($key)
    {
        return static::find()
            ->select('id')
            ->byKey($key)
            ->scalar();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'translateable' => [
                'class' => TranslateableBehavior::class,
                'translationAttributes' => $this->getTranslationAttributes(),
            ],
        ];
    }

    /**
     * Returns list of translation attributes.
     *
     * @return string[]
     */
    public function getTranslationAttributes()
    {
        return [
            'language',
            'subject',
            'body',
            'hint',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['key'], 'string', 'max' => 255],
            [['key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'    => Yii::t('email-templates/entity', 'ID'),
            'key'   => Yii::t('email-templates/entity', 'Key'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            'default' => self::OP_ALL,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(EmailTemplateTranslation::class, ['templateId' => 'id']);
    }
}

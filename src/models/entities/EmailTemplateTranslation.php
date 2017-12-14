<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\models\entities;

use Yii;
use yii\db\ActiveRecord;
use motion\i18n\LanguageProviderInterface;

/**
 * This is the model class for table "{{%email_template_translation}}".
 *
 * @property int $id
 * @property int $templateId
 * @property string $language
 * @property string $subject
 * @property string $body
 * @property string $hint
 *
 * @property EmailTemplate $template
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class EmailTemplateTranslation extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email_template_translation}}';
    }

    /**
     * Returns internal form name.
     *
     * @return string
     */
    public static function internalFormName()
    {
        $reflector = new \ReflectionClass(self::class);
        return $reflector->getShortName();
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return parent::formName() . '[' . $this->language . ']';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->hint = 'All tokens wrapped in {} will be replaced by real data';
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['templateId', 'language'], 'safe'],

            ['subject', 'required'],
            ['subject', 'string', 'max' => 255],

            ['body', 'required'],
            ['body', 'string'],

            ['hint', 'required'],
            ['hint', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'subject'       => Yii::t('email-templates/entity', 'Subject'),
            'body'          => Yii::t('email-templates/entity', 'Body'),
            'hint'          => Yii::t('email-templates/entity', 'Hint'),
        ];

        foreach ($labels as $key => $label) {
            $labels[$key] = $this->addLabelPostfix($label);
        }
        
        return $labels;
    }

    /**
     * Adds prefix to label.
     *
     * @param string $label
     * @return string
     */
    protected function addLabelPostfix($label)
    {
        return $label . ' [' . $this->language . ']';
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
    public function getTemplate()
    {
        return $this->hasOne(EmailTemplate::class, ['id' => 'templateId']);
    }
}

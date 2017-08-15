<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\models\entities;

use Yii;
use yii\db\ActiveRecord;
use yii2deman\tools\i18n\LanguageProviderInterface;

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
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [['templateId'], 'required'],
            [['templateId'], 'integer'],

            [['language'], 'required'],
            [['language'], 'string', 'max' => 16],

            [['subject'], 'required'],
            [['subject'], 'string', 'max' => 255],

            [['body'], 'required'],
            [['body'], 'string'],

            [['hint'], 'required'],
            [['hint'], 'string'],
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('email-templates/entity', 'ID'),
            'templateId'    => Yii::t('email-templates/entity', 'Template ID'),
            'language'      => Yii::t('email-templates/entity', 'Language'),
            'subject'       => Yii::t('email-templates/entity', 'Subject'),
            'body'          => Yii::t('email-templates/entity', 'Body'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        /* @var LanguageProviderInterface $languageProvider */
        $languageProvider = Yii::$container->get(LanguageProviderInterface::class);

        return [
            'subject' => '[' . $languageProvider->getLanguageLabel($this->language) . '] ' . $this->subject,
            'body' => '[' . $languageProvider->getLanguageLabel($this->language) . '] ' . strip_tags($this->body),
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

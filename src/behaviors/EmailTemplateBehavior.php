<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;
use ymaker\email\templates\models\entities\EmailTemplate;
use ymaker\email\templates\models\entities\EmailTemplateTranslation;

/**
 * Behavior for appending of email templates to ActiveRecord models.
 *
 * @property string $letterSubject
 * @property string $letterBody
 * @property string $emailTemplateHint
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 3.0
 */
class EmailTemplateBehavior extends Behavior
{
    /**
     * @var BaseActiveRecord
     */
    public $owner;

    /**
     * @var string
     */
    private $_key = 'default';
    /**
     * @var string
     */
    private $_languageAttribute = 'language';
    /**
     * @var EmailTemplate
     */
    private $_template;


    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->_key = $key;
    }

    /**
     * @param string $value
     */
    public function setLanguageAttribute($value)
    {
        $this->_languageAttribute = $value;
    }

    /**
     * @return string
     */
    public function getLetterSubject()
    {
        return $this->getTranslation()->subject;
    }

    /**
     * @param string $subject
     */
    public function setLetterSubject($subject)
    {
        $this->getTranslation()->subject = $subject;
    }

    /**
     * @return string
     */
    public function getLetterBody()
    {
        return $this->getTranslation()->body;
    }

    /**
     * @param string $body
     */
    public function setLetterBody($body)
    {
        $this->getTranslation()->body = $body;
    }

    /**
     * @return string
     */
    public function getEmailTemplateHint()
    {
        return $this->getTranslation()->hint;
    }

    /**
     * @param string $hint
     */
    public function setEmailTemplateHint($hint)
    {
        $this->getTranslation()->hint = $hint;
    }

    /**
     * @return EmailTemplateTranslation
     */
    private function getTranslation()
    {
        $language = $this->owner->{$this->_languageAttribute};
        return $this->_template->getTranslation($language);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->getEmailTemplate();
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_FIND      => 'getEmailTemplate',
            BaseActiveRecord::EVENT_AFTER_INSERT    => 'saveEmailTemplate',
            BaseActiveRecord::EVENT_AFTER_UPDATE    => 'saveEmailTemplate',
            BaseActiveRecord::EVENT_AFTER_DELETE    => 'deleteEmailTemplate',
        ];
    }

    /**
     * Get email template from database.
     */
    public function getEmailTemplate()
    {
        if ($this->owner !== null) {
            $this->_template = EmailTemplate::find()
                ->byKey($this->generateKey())
                ->withTranslation($this->owner->{$this->_languageAttribute})
                ->one();
        } else {
            $this->_template = new EmailTemplate();
        }
    }

    /**
     * Save email template to database.
     */
    public function saveEmailTemplate()
    {
        if ($this->_template->key === null) {
            $this->_template->key = $this->generateKey();
        }

        try {
            $this->_template->save();
        } catch (\Exception $ex) {
            Yii::$app->getErrorHandler()->logException($ex);
        }
    }

    /**
     * Delete email template.
     */
    public function deleteEmailTemplate()
    {
        try {
            $this->_template->delete();
        } catch (\Exception $ex) {
            Yii::$app->getErrorHandler()->logException($ex);
        }
    }

    /**
     * Generates key for email template.
     *
     * @return string
     */
    protected function generateKey()
    {
        return Json::encode([
            'model' => get_class($this->owner),
            'id'    => $this->owner->getPrimaryKey(),
            'key'   => $this->_key,
        ]);
    }
}

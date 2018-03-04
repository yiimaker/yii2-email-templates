<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017-2018 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\behaviors;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;
use ymaker\email\templates\repositories\EmailTemplatesRepositoryInterface;

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
     * @var EmailTemplatesRepositoryInterface
     */
    private $_repository;
    /**
     * @var string
     */
    private $_key = 'default';
    /**
     * @var string
     */
    private $_languageAttribute = 'language';
    /**
     * @var \ymaker\email\templates\entities\EmailTemplate
     */
    private $_template;


    /**
     * {@inheritdoc}
     */
    public function __construct(
        EmailTemplatesRepositoryInterface $repository,
        $config = []
    ) {
        $this->_repository = $repository;

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->fetchEmailTemplate();
    }

    /**
     * {@inheritdoc}
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_FIND      => 'fetchEmailTemplate',
            BaseActiveRecord::EVENT_AFTER_INSERT    => 'saveEmailTemplate',
            BaseActiveRecord::EVENT_AFTER_UPDATE    => 'saveEmailTemplate',
            BaseActiveRecord::EVENT_AFTER_DELETE    => 'deleteEmailTemplate',
        ];
    }

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
     * Fetch email template from database.
     */
    public function fetchEmailTemplate()
    {
        if (null !== $this->owner) {
            $this->_template = $this->_repository->getByKeyWithTranslation(
                $this->generateKey(),
                $this->owner->{$this->_languageAttribute}
            );
        } else {
            $this->_template = $this->_repository->create();
        }
    }

    /**
     * Save email template to database.
     */
    public function saveEmailTemplate()
    {
        if (null === $this->_template->key) {
            $this->_template->key = $this->generateKey();
        }

        $this->_repository->save($this->_template);
    }

    /**
     * Delete email template.
     */
    public function deleteEmailTemplate()
    {
        $this->_repository->deleteObject($this->_template);
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

    /**
     * @return \ymaker\email\templates\entities\EmailTemplateTranslation
     */
    private function getTranslation()
    {
        $language = $this->owner->{$this->_languageAttribute};

        return $this->_template->getTranslation($language);
    }
}

<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\models;

use yii\base\BaseObject;

/**
 * Model class for template manager.
 * @see \ymaker\email\templates\components\TemplateManager
 *
 * @property string $subject
 * @property string $body
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class EmailTemplate extends BaseObject
{
    /**
     * Email letter subject.
     *
     * @var string
     */
    private $_subject;
    /**
     * Email letter body.
     *
     * @var string
     */
    private $_body;


    /**
     * Getter for subject.
     *
     * @return string
     * @since 2.0
     */
    public function getSubject()
    {
        return $this->_subject;
    }

    /**
     * Getter for body.
     *
     * @return string
     * @since 2.0
     */
    public function getBody()
    {
        return $this->_body;
    }

    /**
     * EmailTemplate constructor.
     *
     * @param string $subject
     * @param string $body
     * @param array $config
     * @since 2.0
     */
    public function __construct($subject, $body, $config = [])
    {
        $this->_subject = $subject;
        $this->_body = $body;

        parent::__construct($config);
    }

    /**
     * Build email template from entity.
     *
     * @param \ymaker\email\templates\models\entities\EmailTemplateTranslation $entity
     * @return EmailTemplate
     */
    public static function buildFromEntity($entity)
    {
        return new self($entity->subject, $entity->body);
    }

    /**
     * Build email templates array from entities.
     *
     * @param \ymaker\email\templates\models\entities\EmailTemplateTranslation[] $entities
     * @return EmailTemplate[]
     */
    public static function buildMultiply($entities)
    {
        $templates = [];
        foreach ($entities as $entity) {
            $templates[$entity->language] = static::buildFromEntity($entity);
        }

        return $templates;
    }

    /**
     * @param array $data
     * @param string $attribute
     */
    protected function replaceKeys($data, $attribute)
    {
        foreach ($data as $key => $value) {
            $this->$attribute = strtr($this->$attribute, [
                '{' . $key . '}' => $value,
            ]);
        }
    }

    /**
     * Replace keys to real data in subject and body.
     *
     * @param array $data Array with key-value pairs.
     */
    public function parse($data)
    {
        if (isset($data['subject'])) {
            $this->replaceKeys($data['subject'], '_subject');
        }
        if (isset($data['body'])) {
            $this->replaceKeys($data['body'], '_body');
        }
    }

    /**
     * Replace keys to real data in subject.
     *
     * @param array $data Array with key-value pairs.
     */
    public function parseSubject($data)
    {
        $this->replaceKeys($data, '_subject');
    }

    /**
     * Replace keys to real data in body.
     *
     * @param array $data Array with key-value pairs.
     */
    public function parseBody($data)
    {
        $this->replaceKeys($data, '_body');
    }
}

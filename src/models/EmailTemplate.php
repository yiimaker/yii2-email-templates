<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\models;

use yii\base\Object;

/**
 * Email template model for processing data
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class EmailTemplate extends Object
{
    /**
     * @var string
     */
    public $subject;
    /**
     * @var string
     */
    public $body;


    /**
     * Build email template from entity
     *
     * @param \ymaker\email\templates\models\entities\EmailTemplateTranslation $entity
     * @return EmailTemplate
     */
    public static function buildFromEntity($entity)
    {
        return new self([
            'subject' => $entity->subject,
            'body' => $entity->body
        ]);
    }

    /**
     * Build email templates array from entities
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
                '{' . $key . '}' => $value
            ]);
        }
    }

    /**
     * Replace keys to real data in subject and body
     *
     * @param array $data
     */
    public function parse($data)
    {
        if (isset($data['subject'])) {
            $this->replaceKeys($data['subject'], 'subject');
        }
        if (isset($data['body'])) {
            $this->replaceKeys($data['body'], 'body');
        }
    }

    /**
     * Replace keys to real data in subject
     *
     * @param array $data
     */
    public function parseSubject($data)
    {
        $this->replaceKeys($data, 'subject');
    }

    /**
     * Replace keys to real data in body
     *
     * @param array $data
     */
    public function parseBody($data)
    {
        $this->replaceKeys($data, 'body');
    }
}

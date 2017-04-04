<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\components;

use Yii;
use yii\base\Object;

use ymaker\email\templates\models\EmailTemplate as EmailTemplateModel;
use ymaker\email\templates\models\entities\EmailTemplate;
use ymaker\email\templates\models\entities\EmailTemplateTranslation;

/**
 * Manager for work with email templates
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class TemplateManager extends Object
{
    /**
     * Returns template model by key and language
     *
     * @param string $key
     * @param null|string $language
     * @return null|EmailTemplateModel
     */
    public function getTemplate($key, $language = null)
    {
        $language ?: Yii::$app->language;

        /* @var EmailTemplate $model */
        $model = EmailTemplate::find()
            ->byKey($key)
            ->withTranslation($language)
            ->one();

        if (isset($model->translations[0])) {
            return EmailTemplateModel::buildFromEntity($model->translations[0]);
        }

        return null;
    }

    /**
     * Returns all template models
     *
     * @param string $key
     * @return null|EmailTemplateModel[]
     */
    public function getAllTemplates($key)
    {
        if ($id = EmailTemplate::findId($key)) {
            /* @var EmailTemplateTranslation[] $templates */
            $templates = EmailTemplateTranslation::findAll(['templateId' => $id]);
            return EmailTemplateModel::buildMultiply($templates);
        }

        return null;
    }

    /**
     * Returns first template translation or default value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getFirstOrDefault($key, $default = null)
    {
        /* @var EmailTemplate $model */
        $model = EmailTemplate::find()
            ->byKey($key)
            ->with('translations')
            ->one();

        return isset($model->translations[0])
            ? $model->translations[0]
            : $default;
    }

    /**
     * Check is template with current key exists
     *
     * @param string $key
     * @return bool
     */
    public function hasTemplate($key)
    {
        return EmailTemplate::find()->byKey($key)->exists();
    }
}

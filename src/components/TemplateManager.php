<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017-2018 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\components;

use Yii;
use yii\base\BaseObject;
use ymaker\email\templates\models\EmailTemplate;
use ymaker\email\templates\repositories\EmailTemplatesRepositoryInterface;

/**
 * This class provides methods for making work with email template easily in your code.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class TemplateManager extends BaseObject
{
    /**
     * @var EmailTemplatesRepositoryInterface
     */
    protected $repository;

    /**
     * {@inheritdoc}
     * @param EmailTemplatesRepositoryInterface $repository
     */
    public function __construct(EmailTemplatesRepositoryInterface $repository, $config = [])
    {
        $this->repository = $repository;
        parent::__construct($config);
    }

    /**
     * Returns template model by key and language.
     *
     * @see EmailTemplateModel
     *
     * @param string        $key
     * @param null|string   $language   Template language.
     * @param mixed         $default    Default value.
     *
     * @return null|EmailTemplate
     */
    public function getTemplate($key, $language = null, $default = null)
    {
        /* @var EmailTemplate $template */
        $template = $this->repository->getByKeyWithTranslation(
            $key,
            $language ?: Yii::$app->language
        );

        return empty($template->translations[0])
            ? $default
            : EmailTemplate::buildFromEntity($template->translations[0]);
    }

    /**
     * Returns email template on all languages.
     *
     * @param string    $key
     * @param mixed     $default Default value.
     *
     * @return null|EmailTemplate[]
     */
    public function getAllTemplates($key, $default = null)
    {
        $templates = $this->repository->getAll($key);

        return null === $templates ? $default : EmailTemplate::buildMultiply($templates);
    }

    /**
     * Check whether template with current key exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasTemplate($key)
    {
        return $this->repository->has($key);
    }
}

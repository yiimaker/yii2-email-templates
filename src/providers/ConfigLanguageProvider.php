<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\providers;

use yii\base\InvalidConfigException;
use yii\base\Object;

/**
 * Config language provider
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class ConfigLanguageProvider extends Object implements LanguageProviderInterface
{
    /**
     * Contains all languages
     *
     * @var array
     */
    public $languages = [];
    /**
     * Contains one default language
     *
     * @var array
     */
    public $defaultLanguage = [];


    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->languages)) {
            throw new InvalidConfigException('\'languages\' field cannot be empty');
        }
        if (empty($this->defaultLanguage)) {
            throw new InvalidConfigException('\'defaultLanguage\' field cannot be empty');
        }
    }

    /**
     * @inheritdoc
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @inheritdoc
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }
}

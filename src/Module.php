<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates;

use Yii;
use yii\base\InvalidConfigException;
use ymaker\email\templates\services\EmailTemplateService;
use ymaker\email\templates\services\ServiceInterface;
use motion\i18n\LanguageProviderInterface;

/**
 * Module for CRUD operations under email templates in backend.
 *
 * @property array $service
 * @property array $languageProvider
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'ymaker\email\templates\controllers';

    /**
     * Service for controller.
     *
     * @see \ymaker\email\templates\services\ServiceInterface
     * @var array
     */
    protected $service;
    /**
     * Language provider for internationalization.
     *
     * @see \motion\i18n\LanguageProviderInterface
     * @var array
     */
    protected $languageProvider;


    /**
     * @param array $service
     * @since 2.0
     */
    public function setService(array $service)
    {
        $this->service = $service;
    }

    /**
     * @param array $provider
     * @since 2.0
     */
    public function setLanguageProvider(array $provider)
    {
        $this->languageProvider = $provider;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->service === null) {
            $this->service = ['class' => EmailTemplateService::class];
        }
        if ($this->languageProvider === null) {
            throw new InvalidConfigException('You should to configure the language provider');
        }

        $this->registerDependencies();
    }

    /**
     * Register dependencies to DI container.
     */
    protected function registerDependencies()
    {
        Yii::$container->setDefinitions([
            ServiceInterface::class => $this->service,
            LanguageProviderInterface::class => $this->languageProvider
        ]);
    }

    /**
     * Module wrapper for `Yii::t()` method.
     *
     * @param string $message
     * @param array $params
     * @param null|string $language
     * @return string
     */
    public static function t($message, $params = [], $language = null)
    {
        return Yii::t('back/email-templates', $message, $params, $language);
    }

    /**
     * Returns url to repository for creation of new issue.
     *
     * @return string
     * @since 3.0
     */
    final public static function getIssueUrl()
    {
        return self::getRepoUrl() . '/issues/new';
    }

    /**
     * Returns url of official repository.
     *
     * @return string
     * @since 3.0
     */
    final public static function getRepoUrl()
    {
        return 'https://github.com/yiimaker/yii2-email-templates';
    }
}

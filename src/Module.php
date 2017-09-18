<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates;

use Yii;
use yii\base\InvalidConfigException;
use ymaker\email\templates\services\DbService;
use ymaker\email\templates\services\ServiceInterface;
use yii2deman\tools\i18n\LanguageProviderInterface;

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
    protected $_service = null;
    /**
     * Language provider for internationalization.
     *
     * @see \yii2deman\tools\i18n\LanguageProviderInterface
     * @var array
     */
    protected $_languageProvider = null;


    /**
     * Setter for service.
     *
     * @param array $service
     * @since 2.0
     */
    public function setService(array $service)
    {
        $this->_service = $service;
    }

    /**
     * Setter for language provider.
     *
     * @param array $provider
     * @since 2.0
     */
    public function setLanguageProvider(array $provider)
    {
        $this->_languageProvider = $provider;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->_service === null) {
            $this->_service = ['class' => DbService::class];
        }
        if ($this->_languageProvider === null) {
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
            ServiceInterface::class => $this->_service,
            LanguageProviderInterface::class => $this->_languageProvider
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
     * @since 2.2.0
     */
    public static function getIssueUrl()
    {
        return 'https://github.com/yiimaker/yii2-email-templates/issues/new';
    }
}

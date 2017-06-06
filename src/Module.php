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
 * Module for CRUD operations under email templates in backend
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
     * Service for controller
     *
     * @see \ymaker\email\templates\services\ServiceInterface
     * @var array
     */
    public $service = null;
    /**
     * Language provider for internationalization
     *
     * @see \ymaker\email\templates\providers\LanguageProviderInterface
     * @var array
     */
    public $languageProvider = null;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->service === null) {
            $this->service = ['class' => DbService::class];
        }
        if ($this->languageProvider === null) {
            throw new InvalidConfigException('You should to configure the language provider');
        }

        $this->registerDependencies();
    }

    /**
     * Register dependencies to DI container
     */
    protected function registerDependencies()
    {
        Yii::$container->setDefinitions([
            ServiceInterface::class => $this->service,
            LanguageProviderInterface::class => $this->languageProvider
        ]);
    }

    /**
     * Module wrapper for `Yii::t()` method
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
}

<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates;
use Yii;
use ymaker\email\templates\services\DbService;
use ymaker\email\templates\services\ServiceInterface;

/**
 * Module for CRUD operations under email templates
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
     * @var array
     */
    public $service = null;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->service === null) {
            $this->service = ['class' => DbService::class];
        }

        $this->registerDependencies();
    }

    /**
     * Register dependencies to Yii DI container
     */
    protected function registerDependencies()
    {
        Yii::$container->set(ServiceInterface::class, $this->service);
    }
}

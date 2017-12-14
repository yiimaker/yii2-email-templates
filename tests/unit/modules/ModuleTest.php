<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\tests\unit\modules;

use Yii;
use ymaker\email\templates\tests\unit\TestCase;
use ymaker\email\templates\Module;
use ymaker\email\templates\services\EmailTemplateService;
use ymaker\email\templates\services\ServiceInterface;
use motion\i18n\LanguageProviderInterface;

/**
 * Test case for module.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class ModuleTest extends TestCase
{
    public function testInitService()
    {
        $module = new Module('test', null, ['languageProvider' => []]);
        $this->assertInstanceOf(EmailTemplateService::class, Yii::$container->get(ServiceInterface::class));
    }

    public function testInitLanguageProvider()
    {
        $this->expectException('yii\base\InvalidConfigException');
        $module = new Module('test');
    }

    public function testInit()
    {
        $module = new Module('test', null, ['languageProvider' => []]);

        $this->assertTrue(Yii::$container->has(ServiceInterface::class));
        $this->assertTrue(Yii::$container->has(LanguageProviderInterface::class));
    }
}

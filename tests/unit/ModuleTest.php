<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017-2019 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\tests\unit;

use Yii;
use ymaker\email\templates\Module;
use ymaker\email\templates\repositories\EmailTemplatesRepository;
use ymaker\email\templates\repositories\EmailTemplatesRepositoryInterface;
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
        new Module('test', null, ['languageProvider' => []]);

        $this->assertInstanceOf(
            EmailTemplatesRepository::class,
            Yii::$container->get(EmailTemplatesRepositoryInterface::class)
        );
    }

    public function testInitLanguageProvider()
    {
        $this->expectException('yii\base\InvalidConfigException');
        new Module('test');
    }

    public function testInit()
    {
        new Module('test', null, ['languageProvider' => []]);

        $this->assertTrue(Yii::$container->has(EmailTemplatesRepositoryInterface::class));
        $this->assertTrue(Yii::$container->has(LanguageProviderInterface::class));
    }
}

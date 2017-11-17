<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\tests\unit\components;

use Yii;
use ymaker\email\templates\models\entities\EmailTemplateTranslation;
use ymaker\email\templates\models\EmailTemplate as EmailTemplateModel;
use ymaker\email\templates\tests\fixtures\EmailTemplateTranslationFixture;
use ymaker\email\templates\tests\unit\DbTestCase;

/**
 * Test case for template manager.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class TemplateManagerTest extends DbTestCase
{
    /**
     * @var \ymaker\email\templates\components\TemplateManager
     */
    private $_manager;
    /**
     * @var string
     */
    private $_key = 'test-template';


    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
            'template' => EmailTemplateTranslationFixture::class,
        ];
    }

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        parent::_before();
        $this->_manager = Yii::$app->get('templateManager');
    }

    public function testGetTemplate()
    {
        $expected = EmailTemplateModel::buildFromEntity(
            EmailTemplateTranslation::findOne(['language' => 'en'])
        );
        $actual = $this->_manager->getTemplate($this->_key);
        $this->assertEquals($expected, $actual);

        $expected = EmailTemplateModel::buildFromEntity(
            EmailTemplateTranslation::findOne(['language' => 'ru'])
        );
        $actual = $this->_manager->getTemplate($this->_key, 'ru');
        $this->assertEquals($expected, $actual);
    }

    public function testGetAllTemplates()
    {
        $expected = EmailTemplateModel::buildMultiply(
            EmailTemplateTranslation::findAll(['templateId' => 1])
        );
        $actual = $this->_manager->getAllTemplates($this->_key);

        $this->assertEquals($expected, $actual);
    }

    public function testGetFirstOrDefault()
    {
        $actual = $this->_manager->getFirstOrDefault($this->_key);
        $this->assertNotNull($actual);

        $actual = $this->_manager->getFirstOrDefault('not exists key');
        $this->assertNull($actual);
    }

    public function testHasTemplate()
    {
        $actual = $this->_manager->hasTemplate($this->_key);
        $this->assertTrue($actual);

        $actual = $this->_manager->hasTemplate('not-exists');
        $this->assertFalse($actual);
    }
}

<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\tests\unit\services;

use yii\data\ActiveDataProvider;
use ymaker\email\templates\models\entities\EmailTemplate;
use ymaker\email\templates\models\entities\EmailTemplateTranslation;
use ymaker\email\templates\services\DbService;
use ymaker\email\templates\tests\unit\DbTestCase;
use ymaker\email\templates\tests\fixtures\EmailTemplateTranslationFixture;

/**
 * Test case for database service
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class DbServiceTest extends DbTestCase
{
    /**
     * @var DbService
     */
    private $_service;


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
        $this->_service = new DbService();
    }

    public function testGetModel()
    {
        $this->assertInstanceOf(EmailTemplate::class, $this->_service->getModel());

        $modelID = 1;
        $expected = EmailTemplate::findOne($modelID);
        $this->assertEquals($expected, $this->_service->getModel($modelID));
    }

    public function testGetTranslationModel()
    {
        // test new template instance
        $this->assertInstanceOf(
            EmailTemplateTranslation::class,
            $this->_service->getTranslationModel()
        );

        // test new template instance with params
        $templateID = 1;
        $language = 'some language locale';
        $expected = new EmailTemplateTranslation([
            'templateId' => $templateID,
            'language' => $language,
        ]);
        $actual = $this->_service->getTranslationModel($templateID, $language);
        $this->assertEquals($expected, $actual);

        // test get template from database
        $language = 'en';
        $expected = EmailTemplateTranslation::findOne([
            'templateId' => $templateID,
            'language' => $language,
        ]);
        $actual = $this->_service->getTranslationModel($templateID, $language);
        $this->assertEquals($expected, $actual);
    }

    public function testCreate()
    {
        $data = [
            'EmailTemplate' => [
                'key' => 'create template test'
            ],
            'EmailTemplateTranslation' => [
                'subject' => 'create template translation test 1',
                'body' => 'create template translation test 2',
                'hint' => 'create template translation test 3',
            ],
        ];

        $res = $this->_service->create($data);

        $this->assertTrue($res);
        $this->tester->seeRecord(EmailTemplate::class, [
            'key' => $data['EmailTemplate']['key']
        ]);
        $this->tester->seeRecord(EmailTemplateTranslation::class, [
            'subject' => $data['EmailTemplateTranslation']['subject'],
            'body' => $data['EmailTemplateTranslation']['body'],
            'hint' => $data['EmailTemplateTranslation']['hint']
        ]);
    }

    public function testUpdate()
    {
        $data = [
            'EmailTemplate' => [
                'key' => 'update template test'
            ],
            'EmailTemplateTranslation' => [
                'subject' => 'update template translation test 1',
                'body' => 'update template translation test 2',
            ],
        ];

        $model = EmailTEmplate::findOne(1);
        $translation = EmailTemplateTranslation::findOne(['language' => 'en']);
        $res = $this->_service->update($model, $translation, $data);

        $this->assertTrue($res);
        $this->tester->seeRecord(EmailTemplate::class, [
            'key' => $data['EmailTemplate']['key']
        ]);
        $this->tester->seeRecord(EmailTemplateTranslation::class, [
            'subject' => $data['EmailTemplateTranslation']['subject'],
            'body' => $data['EmailTemplateTranslation']['body'],
        ]);
    }
}

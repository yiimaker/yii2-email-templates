<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\banner\tests\unit\backend\services;

use yii\data\ActiveDataProvider;
use ymaker\email\templates\entities\EmailTemplate;
use ymaker\email\templates\entities\EmailTemplateTranslation;
use ymaker\email\templates\services\EmailTemplateService;
use ymaker\email\templates\services\ServiceInterface;
use ymaker\email\templates\tests\fixtures\EmailTemplateTranslationFixture;
use ymaker\email\templates\tests\unit\DbTestCase;

/**
 * Test case for email template service.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 3.0
 */
class EmailTemplateServiceTest extends DbTestCase
{
    /**
     * @var EmailTemplateService
     */
    protected $service;


    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [EmailTemplateTranslationFixture::class];
    }

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        parent::_before();
        $this->service = new EmailTemplateService();
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf(
            ServiceInterface::class,
            $this->service
        );
    }

    public function testGetDataProvider()
    {
        $this->testInstanceOf(ActiveDataProvider::class, $this->service->getDataProvider());
    }

    public function testGetModelNewInstance()
    {
        $model = $this->service->getModel();

        $this->assertInstanceOf(EmailTemplate::class, $model);
        $this->assertTrue($model->getIsNewRecord());
    }

    public function testGetModelFromDb()
    {
        $model = $this->service->getModel(1);

        $this->assertInstanceOf(EmailTemplate::class, $model);
        $this->assertFalse($model->getIsNewRecord());
    }

    /**
     * @expectedException \yii\web\NotFoundHttpException
     */
    public function testGetModelException()
    {
        $this->service->getModel(999);
    }

    public function testSave()
    {
        $templateData = ['key' => 'save-test'];
        $templateDataEn = [
            'language' => 'en',
            'subject' => 'this is subject',
            'body' => 'this is body',
            'hint' => 'this is hint',
        ];
        $templateDataRu = [
            'language' => 'ru',
            'subject' => 'это тема',
            'body' => 'это тело',
            'hint' => 'это подсказка',
        ];

        $data = [
            'EmailTemplate' => $templateData,
            'EmailTemplateTranslation' => [
                'en' => $templateDataEn,
                'ru' => $templateDataRu,
            ],
        ];
        $this->service->getModel();
        $res = $this->service->save($data);

        $this->assertTrue($res);
        $this->tester->seeRecord(EmailTemplate::class, $templateData);
        $this->tester->seeRecord(EmailTemplateTranslation::class, $templateDataEn);
        $this->tester->seeRecord(EmailTemplateTranslation::class, $templateDataRu);
    }

    public function testDelete()
    {
        $res = $this->service->delete(1);

        $this->assertTrue($res);
        $this->tester->dontSeeRecord(EmailTemplate::class, ['key' => 'test-template']);
    }

    /**
     * @expectedException \yii\web\NotFoundHttpException
     */
    public function testDeleteException()
    {
        $this->service->delete(999);
    }
}

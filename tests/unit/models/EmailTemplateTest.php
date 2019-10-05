<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017-2019 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\tests\unit\models;

use ymaker\email\templates\tests\unit\DbTestCase;
use ymaker\email\templates\entities\EmailTemplateTranslation as Entity;
use ymaker\email\templates\models\EmailTemplate;
use ymaker\email\templates\tests\fixtures\EmailTemplateTranslationFixture;

/**
 * Test case for email template model.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class EmailTemplateTest extends DbTestCase
{
    /**
     * {@inheritdoc}
     */
    public function fixtures()
    {
        return [
            'template' => EmailTemplateTranslationFixture::class,
        ];
    }

    public function testBuildFromEntity()
    {
        /* @var Entity $entity */
        $entity = Entity::findOne(['templateId' => 1]);

        $expected = new EmailTemplate($entity->subject, $entity->body);
        $actual = EmailTemplate::buildFromEntity($entity);

        $this->assertEquals($expected, $actual);
    }

    public function testBuildMultiply()
    {
        /* @var Entity[] $entities */
        $entities = Entity::find()->all();

        $expected = [];

        foreach ($entities as $entity) {
            $expected[$entity->language] = new EmailTemplate($entity->subject, $entity->body);
        }
        $actual = EmailTemplate::buildMultiply($entities);

        $this->assertEquals($expected, $actual);
    }

    public function testParse()
    {
        /* @var Entity $entity */
        $entity = Entity::findOne(['templateId' => 1]);
        /* @var EmailTemplate $template */
        $template = EmailTemplate::buildFromEntity($entity);
        $subjectVal = 'parssed subject';
        $bodyVal = 'parssed body';

        $template->parse([
            'subject' => [
                'test-key' => $subjectVal,
            ],
            'body' => [
                'test-key' => $bodyVal,
            ],
        ]);
        $this->assertStringEndsWith($subjectVal, $template->subject);
        $this->assertStringEndsWith($bodyVal, $template->body);
    }

    public function testParseSubject()
    {
        /* @var Entity $entity */
        $entity = Entity::findOne(['templateId' => 1]);
        /* @var EmailTemplate $template */
        $template = EmailTemplate::buildFromEntity($entity);
        $value = 'parssed subject';

        $template->parseSubject(['test-key' => $value]);
        $this->assertStringEndsWith($value, $template->subject);
    }

    public function testParseBody()
    {
        /* @var Entity $entity */
        $entity = Entity::findOne(['templateId' => 1]);
        /* @var EmailTemplate $template */
        $template = EmailTemplate::buildFromEntity($entity);
        $value = 'parssed body';

        $template->parseBody(['test-key' => $value]);
        $this->assertStringEndsWith($value, $template->body);
    }
}

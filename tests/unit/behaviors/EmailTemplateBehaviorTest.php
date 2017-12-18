<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\tests\unit\behaviors;

use yii\helpers\Json;
use ymaker\email\templates\behaviors\EmailTemplateBehavior;
use ymaker\email\templates\models\entities\EmailTemplate;
use ymaker\email\templates\models\entities\EmailTemplateTranslation;
use ymaker\email\templates\tests\mocks\DemoActiveRecord;
use ymaker\email\templates\tests\unit\TestCase;

/**
 * Test case for email template behavior.
 *
 * @property \UnitTester $tester
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 3.0
 */
class EmailTemplateBehaviorTest extends TestCase
{
    public function testNewModel()
    {
        DemoActiveRecord::$behaviors = [EmailTemplateBehavior::class];
        $model = new DemoActiveRecord([
            'subject' => 'this is subject',
            'body' => 'this is body',
            'hint' => 'this is hint',
        ]);
        $model->save(false);

        $this->tester->seeRecord(EmailTemplate::class, [
            'key' => Json::encode([
                'model' => DemoActiveRecord::class,
                'id'    => $model->id,
                'key'   => 'default',
            ])
        ]);
        $this->tester->seeRecord(EmailTemplateTranslation::class, [
            'subject' => 'this is subject',
            'body' => 'this is body',
            'hint' => 'this is hint',
        ]);
    }

    public function testFindModel()
    {
        DemoActiveRecord::$behaviors = ['templates' => EmailTemplateBehavior::class];
        $model = new DemoActiveRecord([
            'subject' => 'this is subject',
            'body' => 'this is body',
            'hint' => 'this is hint',
        ]);
        $model->save(false);

        $foundedModel = DemoActiveRecord::findOne($model->id);

        $this->assertEquals('this is subject', $foundedModel->subject);
        $this->assertEquals('this is body', $foundedModel->body);
        $this->assertEquals('this is hint', $foundedModel->hint);
    }

    public function testUpdateModel()
    {
        DemoActiveRecord::$behaviors = [EmailTemplateBehavior::class];
        $model = new DemoActiveRecord([
            'subject' => 'this is subject',
            'body' => 'this is body',
            'hint' => 'this is hint',
        ]);
        $model->save(false);

        $model->subject = 'this is updated subject';
        $model->body = 'this is updated body';
        $model->hint = 'this is updated hint';
        $model->save(false);

        $this->tester->seeRecord(EmailTemplateTranslation::class, [
            'subject' => 'this is updated subject',
            'body' => 'this is updated body',
            'hint' => 'this is updated hint',
        ]);
    }

    public function testDeleteModel()
    {
        DemoActiveRecord::$behaviors = [EmailTemplateBehavior::class];
        $model = new DemoActiveRecord([
            'subject' => 'temp subject',
            'body' => 'temp body',
            'hint' => 'temp hint',
        ]);
        $model->save(false);

        $id = $model->id;
        $model->delete();

        $this->tester->dontSeeRecord(EmailTemplate::class, [
            'key' => Json::encode([
                'model' => DemoActiveRecord::class,
                'id'    => $id,
                'key'   => 'default',
            ])
        ]);
    }

    public function testMultiple()
    {
        DemoActiveRecord::$behaviors = [
            'first' => [
                'class' => EmailTemplateBehavior::class,
                'key' => 'first',
            ],
            'second' => [
                'class' => EmailTemplateBehavior::class,
                'key' => 'second',
            ],
        ];

        $model = new DemoActiveRecord();
        $first = $model->getBehavior('first');
        $second = $model->getBehavior('second');

        $first->subject = 'first subject';
        $first->body = 'first body';
        $first->hint = 'first hint';

        $second->subject = 'second subject';
        $second->body = 'second body';
        $second->hint = 'second hint';

        $model->save();

        $this->tester->seeRecord(EmailTemplate::class, [
            'key' => Json::encode([
                'model' => DemoActiveRecord::class,
                'id'    => $model->id,
                'key'   => 'first',
            ])
        ]);
        $this->tester->seeRecord(EmailTemplate::class, [
            'key' => Json::encode([
                'model' => DemoActiveRecord::class,
                'id'    => $model->id,
                'key'   => 'second',
            ])
        ]);
    }
}

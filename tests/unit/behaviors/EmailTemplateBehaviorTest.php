<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\tests\unit\behaviors;

use yii\helpers\Json;
use ymaker\email\templates\behaviors\EmailTemplateBehavior;
use ymaker\email\templates\entities\EmailTemplate;
use ymaker\email\templates\entities\EmailTemplateTranslation;
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
            'letterSubject' => 'this is subject',
            'letterBody' => 'this is body',
            'emailTemplateHint' => 'this is hint',
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
            'letterSubject' => 'this is subject',
            'letterBody' => 'this is body',
            'emailTemplateHint' => 'this is hint',
        ]);
        $model->save(false);

        $foundedModel = DemoActiveRecord::findOne($model->id);

        $this->assertEquals('this is subject', $foundedModel->letterSubject);
        $this->assertEquals('this is body', $foundedModel->letterBody);
        $this->assertEquals('this is hint', $foundedModel->emailTemplateHint);
    }

    public function testUpdateModel()
    {
        DemoActiveRecord::$behaviors = [EmailTemplateBehavior::class];
        $model = new DemoActiveRecord([
            'letterSubject' => 'this is subject',
            'letterBody' => 'this is body',
            'emailTemplateHint' => 'this is hint',
        ]);
        $model->save(false);

        $model->letterSubject = 'this is updated subject';
        $model->letterBody = 'this is updated body';
        $model->emailTemplateHint = 'this is updated hint';
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
            'letterSubject' => 'temp subject',
            'letterBody' => 'temp body',
            'emailTemplateHint' => 'temp hint',
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

        $first->letterSubject = 'first subject';
        $first->letterBody = 'first body';
        $first->emailTemplateHint = 'first hint';

        $second->letterSubject = 'second subject';
        $second->letterBody = 'second body';
        $second->emailTemplateHint = 'second hint';

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

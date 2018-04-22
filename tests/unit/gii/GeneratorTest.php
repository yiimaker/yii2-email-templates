<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017-2018 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\tests\unit\gii;

use Yii;
use ymaker\email\templates\gii\Generator;
use ymaker\email\templates\tests\unit\TestCase;

/**
 * Test case for Gii generator.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 2.0
 */
class GeneratorTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        Yii::setAlias('@console/migrations', '@tests/_output');
    }

    public function testValidate()
    {
        $generator = new Generator();
        $generator->key = 'test-template';
        $generator->subject = 'test subject';
        $generator->body = 'test body';
        $generator->hint = 'test hint';

        $this->assertTrue($generator->validate());
    }

    public function testGenerate()
    {
        $generator = new Generator();
        $generator->key = 'test-template';
        $generator->subject = 'test subject';
        $generator->body = 'test body';
        $generator->hint = 'test hint';
        $files = $generator->generate();
        $migrationCode = $files[0]->content;

        // insert template
        $this->assertContains("'key' => 'test-template'", $migrationCode);

        // get template ID
        $this->assertContains("->where(['key' => 'test-template'])", $migrationCode);

        // insert template data
        $this->assertContains("'subject'       => 'test subject',", $migrationCode);
        $this->assertContains("'body'          => 'test body',", $migrationCode);
        $this->assertContains("'hint'          => 'test hint',", $migrationCode);

        // delete template
        $this->assertContains("':key' => 'test-template',", $migrationCode);
    }
}

<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017-2019 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\tests\unit\gii;

use Yii;
use ymaker\email\templates\gii\Generator;
use ymaker\email\templates\tests\unit\TestCase;

/**
 * Test case for Gii generator.
 *
 * @author Volodymyr Kupriienko <vldmr.kuprienko@gmail.com>
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
        $this->assertStringContainsString("'key' => 'test-template'", $migrationCode);

        // get template ID
        $this->assertStringContainsString("->where(['key' => 'test-template'])", $migrationCode);

        // insert template data
        $this->assertStringContainsString("'subject'       => 'test subject',", $migrationCode);
        $this->assertStringContainsString("'body'          => 'test body',", $migrationCode);
        $this->assertStringContainsString("'hint'          => 'test hint',", $migrationCode);

        // delete template
        $this->assertStringContainsString("':key' => 'test-template',", $migrationCode);
    }
}

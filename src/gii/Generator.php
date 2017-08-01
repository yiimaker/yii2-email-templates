<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\gii;

use Yii;
use yii\gii\CodeFile;

/**
 * This generator will be generate a email template.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.1
 */
class Generator extends \yii\gii\Generator
{
    /**
     * @var string Email template key.
     */
    public $key;
    /**
     * @var string Subject of email letter.
     */
    public $subject;
    /**
     * @var string Body of email letter.
     */
    public $body;
    /**
     * @var string Hints for user.
     */
    public $hint;
    /**
     * @var string
     */
    public $migrationName = null;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->migrationName === null) {
            $this->migrationName = 'm' . gmdate('ymd_His') . '_add_email_template';
        }
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Email template generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator generates a migration for adding of email template.';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['migrationName'], 'safe'],
            [['key', 'subject', 'body'], 'required'],
            [['hint'], 'string', 'max' => 500],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'key'       => 'Template key',
            'subject'   => 'Letter subject',
            'body'      => 'Letter body',
            'hint'      => 'Hints for user',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return ['email-template.php'];
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $params = [
            'key'       => $this->key,
            'subject'   => $this->subject,
            'body'      => $this->body,
            'hint'      => $this->hint,
        ];

        $templateFile = new CodeFile(
            $this->getMigrationAlias(),
            $this->render('email-template.php', $params)
        );

        return [$templateFile];
    }

    /**
     * @return bool|string
     */
    protected function getMigrationAlias()
    {
        return Yii::getAlias('@console/migrations/' . $this->migrationName . '.php');
    }
}

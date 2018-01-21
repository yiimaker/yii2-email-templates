<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\migrations;

use yii\db\Migration;

/**
 * Handles the creation of tables `email_template` and `email_template_translation`.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 3.0
 */
class m171119_140800_create_email_template_entities extends Migration
{
    /**
     * @var string
     */
    protected $primaryTableName = '{{%email_template}}';
    /**
     * @var string
     */
    protected $translationTableName = '{{%email_template_translation}}';


    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            /* @link http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci */
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Tables
        $this->createTable(
            $this->primaryTableName,
            [
                'id'    => $this->primaryKey()->unsigned(),
                'key'   => $this->string()->notNull()->unique(),
            ],
            $tableOptions
        );
        $this->createTable(
            $this->translationTableName,
            [
                'id'            => $this->primaryKey()->unsigned(),
                'templateId'    => $this->integer()->unsigned()->notNull(),
                'language'      => $this->string(16)->notNull(),
                'subject'       => $this->string()->notNull(),
                'body'          => $this->text()->notNull(),
                'hint'          => $this->string(500),
            ],
            $tableOptions
        );

        // Indexes
        $this->createIndex(
            'idx-email_template-key',
            $this->primaryTableName,
            'key',
            true
        );
        $this->createIndex(
            'idx-email_template_translation-templateId',
            $this->translationTableName,
            'templateId'
        );
        $this->createIndex(
            'idx-email_template_translation-language',
            $this->translationTableName,
            'language'
        );

        // Foreign keys
        $this->addForeignKey(
            'fk-email_template_translation-email_template',
            $this->translationTableName,
            'templateId',
            $this->primaryTableName,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-email_template_translation-email_template', $this->primaryTableName);

        $this->dropIndex('idx-email_template_translation-language', $this->translationTableName);
        $this->dropIndex('idx-email_template_translation-templateId', $this->translationTableName);
        $this->dropIndex('idx-email_template-key', $this->primaryTableName);

        $this->dropTable($this->translationTableName);
        $this->dropTable($this->primaryTableName);
    }
}

<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

use yii\db\Migration;

/**
 * Handles the creation of table `email_template_translation`.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class m170331_142547_create_email_template_translation_table extends Migration
{
    /**
     * @var string Table name
     */
    public $tableName = '{{%email_template_translation}}';
    /**
     * @var string Reference table name
     */
    public $refTableName = '{{%email_template}}';


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

        $this->createTable($this->tableName, [
            'id'            => $this->primaryKey(),
            'templateId'    => $this->integer()->notNull(),
            'language'      => $this->string(16)->notNull(),
            'subject'       => $this->string(),
            'body'          => $this->text()
        ], $tableOptions);

        // Foreign keys
        $this->addForeignKey(
            'email_template_translation-email_template-FK',
            $this->tableName, 'templateId',
            $this->refTableName, 'id',
            'CASCADE', 'CASCADE'
        );

        // Indexes
        $this->createIndex(
            'email_template_translation-templateId-IDX',
            $this->tableName,
            'templateId'
        );
        $this->createIndex(
            'email_template_translation-language-IDX',
            $this->tableName,
            'language'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // Foreign keys
        $this->dropForeignKey('email_template_translation-email_template-FK', $this->tableName);

        // Indexes
        $this->dropIndex('email_template_translation-templateId-IDX', $this->tableName);
        $this->dropIndex('email_template_translation-language-IDX', $this->tableName);

        $this->dropTable($this->tableName);
    }
}

<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

use yii\db\Migration;

/**
 * Handles the creation of table `email_template`.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class m170331_142542_create_email_template_table extends Migration
{
    /**
     * @var string Table name.
     */
    public $tableName = '{{%email_template}}';


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
            'id'    => $this->primaryKey(),
            'key'   => $this->string()->notNull()->unique()
        ], $tableOptions);

        // Indexes
        $this->createIndex(
            'email_template-key-IDX',
            $this->tableName,
            'key',
            true
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // Indexes
        $this->dropIndex('email_template-key-IDX', $this->tableName);

        $this->dropTable($this->tableName);
    }
}

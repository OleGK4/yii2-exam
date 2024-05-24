<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m240524_070011_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->unique()->notNull(),
            'phone' => $this->string()->notNull(),
            'FIO' => $this->string()->notNull(),
            'email' => $this->string()->unique()->notNull(),
            'password' => $this->string()->notNull(),
            'licence' => $this->string()->notNull(),
            'role' => $this->integer()->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}

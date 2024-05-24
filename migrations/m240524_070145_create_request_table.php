<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%vehicle}}`
 */
class m240524_070145_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'vehicle_id' => $this->integer()->defaultValue(1),
            'status' => $this->integer()->notNull()->defaultValue(0),
            'date' => $this->date()->notNull(),
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-request-author_id}}',
            '{{%request}}',
            'author_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-request-author_id}}',
            '{{%request}}',
            'author_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `vehicle_id`
        $this->createIndex(
            '{{%idx-request-vehicle_id}}',
            '{{%request}}',
            'vehicle_id'
        );

        // add foreign key for table `{{%vehicle}}`
        $this->addForeignKey(
            '{{%fk-request-vehicle_id}}',
            '{{%request}}',
            'vehicle_id',
            '{{%vehicle}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-request-author_id}}',
            '{{%request}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-request-author_id}}',
            '{{%request}}'
        );

        // drops foreign key for table `{{%vehicle}}`
        $this->dropForeignKey(
            '{{%fk-request-vehicle_id}}',
            '{{%request}}'
        );

        // drops index for column `vehicle_id`
        $this->dropIndex(
            '{{%idx-request-vehicle_id}}',
            '{{%request}}'
        );

        $this->dropTable('{{%request}}');
    }
}

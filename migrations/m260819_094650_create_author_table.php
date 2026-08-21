<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%author}}`.
 */
class m260819_094650_create_author_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'last_name' => $this->string(),
            'first_name' => $this->string(),
            'patronymic' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%author}}');
    }
}

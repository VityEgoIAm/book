<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m260819_093350_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'isbn' => $this->string(13),
            'title' => $this->string(),
            'year' => $this->smallInteger(4),
            'description' => $this->text(),
            'photo' => $this->string(),
            'stock' => $this->boolean()->defaultValue(false), 
        ]);
        $this->addPrimaryKey('pk-book-isbn', '{{%book}}', 'isbn');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey('pk-book-isbn', '{{%book}}');
        $this->dropTable('{{%book}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_author}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%book}}`
 * - `{{%author}}`
 */
class m260819_122215_create_junction_table_for_book_and_author_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_author}}', [
            'id' => $this->primaryKey(),
            'book_isbn' => $this->string(13),
            'author_id' => $this->integer(),
        ]);

        // creates index for column `book_isbn`
        $this->createIndex(
            '{{%idx-book_author-book_isbn}}',
            '{{%book_author}}',
            'book_isbn'
        );

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-book_author-author_id}}',
            '{{%book_author}}',
            'author_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `book_isbn`
        $this->dropIndex(
            '{{%idx-book_author-book_isbn}}',
            '{{%book_author}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-book_author-author_id}}',
            '{{%book_author}}'
        );

        $this->dropTable('{{%book_author}}');
    }
}

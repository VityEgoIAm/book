<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "book_author".
 *
 * @property int $id
 * @property string|null $book_isbn
 * @property int|null $author_id
 *
 */
class BookAuthor extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_isbn', 'author_id'], 'required'],
            [['author_id'], 'integer'],
            [['book_isbn'], 'string', 'max' => 13],
            [['author_id'], 'unique', 'targetAttribute' => ['book_isbn', 'author_id']],
            [['book_isbn'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_isbn' => 'isbn']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'book_isbn' => 'ISBN',
            'author_id' => 'ID автора',
        ];
    }

    public function getAutorList()
    {
        return Author::find()->select(new Expression("CONCAT(`last_name`, ' ', `first_name`, ' ', `patronymic`), id"))->indexBy('id')->column();
    }

    /**
     * Creates and populates a set of models.
     *
     * @param string $modelClass
     * @param array $multipleModels
     * @return array
     */
    public static function createMultiple($modelClass, $multipleModels = [])
    {
        $model    = new $modelClass;
        $formName = $model->formName();
        $post     = Yii::$app->request->post($formName);
        $models   = [];

        if (! empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                    $models[] = $multipleModels[$item['id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }
}

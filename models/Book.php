<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "book".
 *
 * @property int $isbn
 * @property string|null $title
 * @property int|null $year
 * @property string|null $description
 * @property string|null $photo
 * @property int|null $stock
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isbn'], 'required'],
            [['isbn'], 'string', 'max' => 13],
            [['title', 'year', 'description', 'photo'], 'default', 'value' => null],
            [['stock'], 'default', 'value' => 0],
            [['year', 'stock'], 'integer'],
            [['description'], 'string'],
            [['title', 'photo'], 'string', 'max' => 255],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'isbn' => 'Isbn',
            'title' => 'Название',
            'year' => 'Год выпуска',
            'description' => 'Описание',
            'photo' => 'Фото главной страницы',
            'image' => 'Фото главной страницы',
            'stock' => 'В наличии',
        ];
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['book_isbn' => 'isbn']);
    }

    public function upload()
    {
        $this->photo = '/uploads/' . $this->image->baseName . '.' . $this->image->extension;
        if ($this->validate()) {
            $this->image->saveAs($this->getUploadPath() . DIRECTORY_SEPARATOR . $this->image->baseName . '.' . $this->image->extension);
            $this->image = null;
            return true;
        } else {
            return false;
        }
    }

    public function getUploadPath()
    {
        $path = Yii::getAlias('@app/web/uploads');
        if (!is_dir($path)) {
            FileHelper::createDirectory($path);
        }
        
        return $path;
    }
}

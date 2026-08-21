<?php

namespace app\models;

use yii\base\Model;

class TopForm extends Model
{
    public $year;

    public function rules()
    {
        return [
            [['year'], 'required'],
            [['year'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'year' => 'Год выпуска',
        ];
    }

    public function getTop()
    {
$sql = <<<SQL
SELECT a.*, COUNT(*) AS count FROM author AS a
LEFT JOIN book_author AS ba ON a.id = ba.author_id 
LEFT JOIN book AS b ON ba.book_isbn = b.isbn
WHERE b.year = :year
GROUP BY a.id, b.year
ORDER BY count DESC
limit 10
SQL;
        if (!empty($this->year) && $this->validate()) {
            return \Yii::$app->db->createCommand($sql)
                ->bindValue(':year', $this->year)
                ->queryAll();
        }
        return false;
    }
}
<?php

namespace app\commands;

use Faker\Factory;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class SeedController extends Controller
{
    public function actionIndex()
    {
        $faker = Factory::create('ru_RU');

        for ($i = 0; $i < 10; $i++) {
            $author = explode(' ', $faker->name());
            Yii::$app->db->createCommand()
                ->insert('author', [
                    'last_name' => $author[0],
                    'first_name' => $author[1],
                    'patronymic' => $author[2],
                ])
                ->execute();
        }

        $isbns = [];
        for ($i = 0; $i < 10; $i++) {
            $isbn = $faker->ean13();
            Yii::$app->db->createCommand()
                ->insert('book', [
                    'title' => rtrim($faker->sentence(5), '.'),
                    'year' => $faker->year(),
                    'description' => $faker->text(),
                    'isbn' => $isbn,
                    'stock' => $faker->boolean(),
                ])
                ->execute();
            $isbns[] = $isbn;
        }

        foreach ($isbns as $isbn) {
            Yii::$app->db->createCommand()
                ->insert('book_author', [
                    'book_isbn' => $isbn,
                    'author_id' => rand(1, 10),
                ])
                ->execute();
        };

        return ExitCode::OK;
    }
}

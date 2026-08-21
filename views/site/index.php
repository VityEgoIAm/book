<?php

/** @var yii\web\View $this */
/** @var app\models\Book[] $books */

use yii\helpers\Html;
use yii\helpers\StringHelper;

$this->title = 'Каталог книг';
$this->params['meta_description'] = 'A high-performance PHP framework best for developing web applications. Fast, secure, and professional.';
$this->params['meta_keywords'] = 'yii, yii2, php, framework, web application, high-performance';
?>
<div class="album py-5 bg-light">
    <div class="container">

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php foreach ($books as $book) : ?>
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm<?= $book->stock ? ' border-primary' : '' ?>">
                        <div class="card-header py-3<?= $book->stock ? ' text-white bg-primary border-primary' : '' ?>">
                            <h4 class="my-0 fw-normal"><?= StringHelper::truncate($book->title, 25, '...', null, true) ?></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title"><?= $book->year ?><small class="text-muted fw-light">год</small></h1>
                            <div class="row">
                                <div class="col p-4 d-flex flex-column position-static">
                                    <?= StringHelper::truncate($book->description, 100, '...', null, true) ?>
                                    <?php if(!$book->stock) : ?>
                                        <a href="#" class="stretched-link">Уведомить о поступлении</a>
                                    <?php endif; ?>
                                </div>
                                <div class="col-auto d-none d-lg-block">
                                    <?php if ($book->photo) : ?>
                                        <?= Html::img($book->photo, ['width' => '200', 'height' => '250',]) ?>
                                    <?php else : ?>
                                        <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Нет обложки</text></svg>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
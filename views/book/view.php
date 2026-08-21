<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'isbn' => $model->isbn], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'isbn' => $model->isbn], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'isbn',
            'title',
            'year',
            'description:ntext',
            [
                'attribute' => 'photo',
                'format' => ['image', ['width' => '150', 'height' => '200']],
            ],
            'stock',
        ],
    ]) ?>

</div>

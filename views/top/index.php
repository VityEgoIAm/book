<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'ТОП 10';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="top-index">
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'year') ?>

        <div class="form-group">
            <?= Html::submitButton('Сформировать', ['class' => 'btn btn-primary']) ?>
        </div>
        
        <?php if ($top = $model->getTop()) : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Количество</th>
                        <th scope="col">Фамилие</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Отчество</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($top as $item) : ?>
                    <tr>
                        <th scope="row"><?= $item['count'] ?></th>
                        <td><?= $item['last_name'] ?></td>
                        <td><?= $item['first_name'] ?></td>
                        <td><?= $item['patronymic'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    <?php ActiveForm::end(); ?>
</div>
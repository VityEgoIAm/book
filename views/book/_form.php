<?php

use Yii2\Extensions\DynamicForm\DynamicFormWidget;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var app\models\BookAuthor[] $authors */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'isbn')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'stock')->checkbox() ?>

    <?php if (isset($authors)): ?>
        <div class="card">
            <div class="card-header">
                Авторы
            </div>
            <div class="card-body">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 4, // the maximum times, an element can be added (default 999)
                    'min' => 0, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $authors[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'book_isbn',
                        'author_id',
                    ],
                ]); ?>

                <div class="container-items"><!-- widgetBody -->
                    <?php foreach ($authors as $index => $author): ?>
                        <div class="item"><!-- widgetItem -->
                            <?php
                                // necessary for update action.
                                if (! $author->isNewRecord) {
                                    echo Html::activeHiddenInput($author, "[{$index}]id");
                                }
                            ?>
                            <?= $form->field($author, "[{$index}]book_isbn")->hiddenInput(['value' => $author->book_isbn])->label(false) ?>
                            <?= $form->field($author, "[{$index}]author_id", [
                                'template' => "{beginWrapper}\n<div class=\"input-group mb-3\">{input}<button class=\"btn btn-danger remove-item\" type=\"button\">&times;</button></div>\n{hint}\n{error}\n{endWrapper}"
                            ])->dropDownList($author->getAutorList())->label('Автор') ?>
                            
                        </div>
                    <?php endforeach; ?>
                </div>
                <?= Html::a('Добавить автора', '#', ['class' => 'add-item btn btn-primary']) ?>

                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
        $(item).find("input[type=\"hidden\"]").val("<?= $model->isbn ?>");
    });
</script>
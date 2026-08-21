<?php

namespace app\controllers;

use app\models\TopForm;
use Yii;
use yii\web\Controller;

class TopController extends Controller
{
    public function actionIndex()
    {
        $model = new TopForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

        }

        return $this->render('index', [
            'model' => $model
        ]);
    }
}
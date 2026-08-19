<?php

namespace app\commands;

use app\models\User;
use yii\console\Controller;

class CreateAdminController extends Controller
{
    public function actionIndex()
    {
        $user = new User();
        $user->login = 'admin';
        $user->email = 'admin@example.com';
        $user->setPassword('admin');
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = User::STATUS_ACTIVE;

        $user->save();
    }
}

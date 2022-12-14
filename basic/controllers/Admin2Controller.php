<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class Admin2Controller extends Controller {

    public function behaviors() {
        return [
        'access' => ['class' => AccessControl::className(), 'rules' => [['allow'=> true, 'roles' => ['@']]]]
        ];
    }


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}

?>
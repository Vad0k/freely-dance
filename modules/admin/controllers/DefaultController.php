<?php

namespace app\modules\admin\controllers;


use app\modules\admin;
use app\models\LoginForm;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller{

    public $layout = 'main';

    public function actionIndex(){


        $modelLoginForm = new LoginForm();

        return $this->render('index',['modelLoginForm'=>$modelLoginForm]);
    }

    public function actionLogin(){

        $modelLoginForm = new LoginForm();
        if ($modelLoginForm->load(Yii::$app->request->post()) && $modelLoginForm->login()) {
            //return $this->goBack();
        }
        return $this->redirect(['/admin/default/index']);
    }

    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->redirect(['/admin/default/index']);
    }


}

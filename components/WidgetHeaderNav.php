<?php
namespace app\components;

use app\models\ModelCategory;
use Yii;
use yii\base\Widget;

class WidgetHeaderNav extends Widget{

    public function init(){
        parent::init();
    }
    public function run(){
        $session = Yii::$app->session;
        $session->open();

        $arrayCategory = ModelCategory::find()->where(['parent_id'=>0,'visible'=>1])->orderBy(['parent_id'=>SORT_ASC,'sort'=>SORT_ASC])->all();
        return $this->render('header-nav',['arrayCategory'=>$arrayCategory, 'session'=>$session]);
    }

}
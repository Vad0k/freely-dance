<?php
namespace app\components;

use app\models\ModelGetContacts;
use yii\base\Widget;

class WidgetFooter extends Widget{

    public function init(){
        parent::init();
    }
    public function run(){
        $modelGetContacts = new ModelGetContacts();
        return $this->render('footer',['modelGetContacts'=>$modelGetContacts]);
    }
}


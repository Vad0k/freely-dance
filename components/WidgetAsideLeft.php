<?php
namespace app\components;

use app\models\MenuHelper;
use app\models\ModelCategory;
use app\models\ModelProducts;
use Yii;
use yii\base\Widget;

class WidgetAsideLeft extends Widget{

    public function init(){
        parent::init();
    }
    public function run(){
        $active = Yii::$app->request->get('id', 0);
        $active = is_numeric($active) ? $active : 0;
        if(Yii::$app->controller->action->id == 'product'){
            $active = ModelProducts::findOne(['id'=>$active])['category_id'];
        }
        $modelAsideMenuNav = new ModelCategory();
        $arrayListMenuNav = $modelAsideMenuNav->find()->where(['visible'=>1])->orderBy(['parent_id'=>SORT_ASC,'sort'=>SORT_ASC])->asArray()->all();

        $menuHelper = new MenuHelper();
        $arrayIdRoots = $menuHelper->getArrayIdParents($arrayListMenuNav, $active);
        $HTML_MenuAsideLeft = $menuHelper->build_menu_active($arrayListMenuNav, $arrayIdRoots, 0, $active);

        return $this->render('aside-left',[
            'arrayListMenuNav'=>$arrayListMenuNav,
            'arrayIdRoots'=>$arrayIdRoots,
            'HTML_MenuAsideLeft'=>$HTML_MenuAsideLeft,
            'active'=>$active
        ]);
    }

}
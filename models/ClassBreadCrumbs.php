<?php
/**
 * Created by PhpStorm.
 * User: Vad0k
 * Date: 24.08.2018
 * Time: 14:01
 */

namespace app\models;


use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

class ClassBreadCrumbs {

    public static function createBreadCrumbs($arrayAllStepNav, &$breadCrumbs){

        for($i = count($arrayAllStepNav)-1; $i >=0; $i--){
            foreach($arrayAllStepNav as $item){
                if($item['id']==$arrayAllStepNav[$i]){
                    $url = '/';
                    if ($item['type'] == 'CATEGORY') {
                        $url = Url::to(['site/category','id'=>$item['id']]);
                    } else if ($item['type'] == 'SUB-CATEGORY') {
                        $url = Url::to(['site/category','id'=>$item['id']]);
                    } else if ($item['type'] == 'PRODUCT') {
                        $url = Url::to(['site/product-list','id'=>$item['id']]);
                    } else {
                        $url = '/';
                    }
                    if(0 != $i){
                        $breadCrumbs->params['breadcrumbs'][] = ['label' => $item['label'], 'url' => $url];
                    }else{
                        $breadCrumbs->params['breadcrumbs'][] = $item['label'];
                    }

                    break;
                }
            }
        }

        return Breadcrumbs::widget([
            'itemTemplate' => "<li><span>{link}</span></li>\n",
            'homeLink' => [
                'label' => 'Главная',
                'url' => Url::to(['site/index']),
            ],
            'links' => isset($breadCrumbs->params['breadcrumbs']) ? $breadCrumbs->params['breadcrumbs'] : [],
        ]);

    }

}
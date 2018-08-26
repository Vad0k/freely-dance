<?php
namespace app\models;

use yii\helpers\Url;

class MenuHelper{

    static function has_children($rows, $id) {
        foreach ($rows as $row) {
            if ($row['parent_id'] == $id) {
                return true;
            }
        }
        return false;
    }

    static function has_parent($rows, $parent_id) {
        foreach ($rows as $row) {
            if ($row['id'] == $parent_id) {
                return true;
            }
        }
        return false;
    }

    static function getArrayIdParents($array, $idChild) {
        $arrayIdParents[] = $idChild;
        foreach ($array as $item) {
            if ($item['id'] == $idChild) {
                if ($item['parent_id'] != 0) {
                    $arrayIdParents = array_merge($arrayIdParents, self::getArrayIdParents($array, $item['parent_id']));
                    break;
                }
                //$arrayIdParents[] = $item['id'];
                break;
            }
        }
        return $arrayIdParents;
    }


    static function build_menu($rows = array(), $parent = 0, $active = 0) {
        $result = '<ul>';
        foreach ($rows as $row) {
            if ($row['parent_id'] == $parent) {

                $url = null;
                if ($row['type'] == 'CATEGORY') {
                    $url = "category.php?id={$row['id']}";
                } else if ($row['type'] == 'SUB-CATEGORY') {
                    $url = "category.php?id={$row['id']}";
                } else if ($row['type'] == 'PRODUCT') {
                    $url = "product-list.php?id={$row['id']}";
                } else if ($row['type'] == 'PAGE'){
                    $url = Url::to([$row['url']]);
                }else{
                    $url = '/';
                }

                $result .= "<li><a class=\"\" href=\"{$url}\">{$row['label']}</a>";
                if (has_children($rows, $row['id'])) {
                    $result .= build_menu($rows, $row['id'], $active);
                }
                $result .= '</li>';
            }
        }
        $result .= '</ul>';
        return $result;
    }

    static function build_menu_active($arrayListMenuNav, $arrayIdRoots, $parent_id, $active = 0) {
        $result = '<ul>';
        foreach($arrayListMenuNav as $item){
            if ($item['parent_id'] == $parent_id) {

                $url = null;
                $class = '';
                if ($item['type'] == 'CATEGORY') {
                    $url = Url::to(['site/category','id'=>$item['id']]);
                } else if ($item['type'] == 'SUB-CATEGORY') {
                    $url = Url::to(['site/category','id'=>$item['id']]);
                    $class = 'have-sub-menu';
                    foreach($arrayIdRoots as $id) {
                        if ($item['id'] == $id) {
                            $class = 'open-sub-menu';
                        }
                    }
                } else if ($item['type'] == 'PRODUCT') {
                    $url = Url::to(['site/product-list','id'=>$item['id']]);
                } else if ($item['type'] == 'PAGE'){
                    $url = Url::to([$item['url']]);
                }else{
                    $url = '/';
                }

                if($active == $item['id']){
                    $result .= "<li><a class=\"active {$class}\" href=\"{$url}\">{$item['label']}</a>";
                }else{
                    $result .= "<li><a class=\"{$class}\" href=\"{$url}\">{$item['label']}</a>";
                }

                foreach($arrayIdRoots as $id){
                    if ($item['id'] == $id) {
                        //$this->params['breadcrumbs'][] = ['label' => $item['label'], 'url' => $url];
                        $result .= self::build_menu_active($arrayListMenuNav, $arrayIdRoots, $id, $active);
                    }
                }

                $result .= '</li>';
            }
        }
        $result .= '</ul>';
        return $result;
    }

}
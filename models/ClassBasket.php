<?php
namespace app\models;

use Yii;
use yii\web\Cookie;

class ClassBasket{

    public function addToBasket($product, $params, $count = 1){


        if(isset($_SESSION['basket'][$product->id])){

            $arrayParams = $_SESSION['basket'][$product->id]['params'];
            foreach($arrayParams as $i => $itemParam) {
                $_SESSION['basket'][$product->id]['params'][$i] = $params[$i];
                /*if($_SESSION['basket'][$product->id]['params'][$i]['isCountPrice'] == 1) {
                    $_SESSION['basket'][$product->id]['params'][$i]['values'] += $params[$i]['values'];
                }*/
            }

            $_SESSION['basket'][$product->id]['count'] += $count;

        }else{
            $_SESSION['basket'][$product->id] = [
                'count' => $count,
                'price' => $product->price,
                'title' => $product->title,
                'image' => $product->image,
                'params'=> $params,
            ];
        }

        $_SESSION['basket.count'] = isset($_SESSION['basket.count']) ? $_SESSION['basket.count'] + $count : $count;
        $_SESSION['basket.sum'] = isset($_SESSION['basket.sum']) ? $_SESSION['basket.sum'] + $product->price * $count : $product->price * $count;
    }


    public function removeProduct($id){
        if(!isset($_SESSION['basket'][$id])) return false;
        $countMinus = $_SESSION['basket'][$id]['count'];
        $sumMinus = $_SESSION['basket'][$id]['price'] * $countMinus;

        $_SESSION['basket.count'] -= $countMinus;
        $_SESSION['basket.sum'] -= $sumMinus;
        unset($_SESSION['basket'][$id]);
        return true;
    }

    public static function clearBasket(){
        $session = Yii::$app->session;
        $session->open();
        $session->remove('basket.sum');
        $session->remove('basket.count');
        $session->remove('basket');
    }

}
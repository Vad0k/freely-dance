<?php
namespace app\controllers;

use app\models\ModelOrder;
use Yii;
use yii\web\Controller;

class PaymentController extends Controller{

    function actionShopSuccess(){
        $post = Yii::$app->request->post();
        $hash = sha1(
            $post['notification_type'].'&'.
            $post['operation_id'].'&'.
            $post['amount'].'&'.
            $post['currency'].'&'.
            $post['datetime'].'&'.
            $post['sender'].'&'.
            $post['codepro'].'&'.
            '2YNg8USv035GBocIQwTzHLZX'.'&'.
            $post['label'].'&'
        );

        if($post['sha1_hash']!=$hash or $post['codepro'] === true or $post['unaccepted'] === true){
            exit('error');
        }

        if($counts = Yii::$app->db->createCommand("UPDATE orders SET status_order=:status WHERE user_hash=:operation_id")->bindValue(':operation_id', $post['operation_id'])->bindValue(':status','ОПЛАЧЕН')->execute()){

        }

    }

}
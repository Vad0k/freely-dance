<?php
namespace app\controllers;

use app\models\ClassBasket;
use app\models\ClassSendOrder;
use app\models\ModelOrder;
use app\models\ModelParams;
use app\models\ModelProducts;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class BasketController extends Controller{

    public function actionAdd($id, $params){ // {'ID':'POSITION','5':'0',...}
        if(!is_numeric($id)) return false;
        $product = ModelProducts::findOne(['id'=>$id,'isVisible'=>1]);
        $sourceParams = json_decode($params, true); // полученный масив {ИД : позиция в поле values}

        if(empty($product) || empty($sourceParams) || !is_array($sourceParams))return false;

        $sqlParams = []; // positions (индексы)
        foreach($sourceParams as $id => $value){
            array_push($sqlParams,$id);
        }
        $arrayListParams = ModelParams::find()->where(['in','id',$sqlParams])->asArray()->all();
        if(empty($arrayProductParams)) false;

        $count = 0;
        for($i = 0, $lengthParams = count($arrayListParams); $i < $lengthParams; $i++){
            foreach($sourceParams as $id => $index){
                if($arrayListParams[$i]['id'] == $id){
                    $itemParams = json_decode($arrayListParams[$i]['values']);
                    if($index >= count($itemParams)) return false;
                    $arrayListParams[$i]['values'] = $itemParams[$index];
                    if($arrayListParams[$i]['isCountPrice']){
                        $count += $arrayListParams[$i]['values'];
                    }
                }
            }
        }

        $session = Yii::$app->session;
        $session->open();
        $modelBasket = new ClassBasket();
        $modelBasket->addToBasket($product, $arrayListParams, $count);
        $this->layout = false;
        return $this->render('cart-modal', ['session'=>$session]);
    }
    public function actionClearBasket(){
        $session = Yii::$app->session;
        $session->open();
        $session->remove('basket.sum');
        $session->remove('basket.count');
        $session->remove('basket');
        $this->layout = false;
        return $this->render('cart-modal', ['session'=>$session]);
    }
    public function actionRemoveProduct($id){
        if(!is_numeric($id)) return false;
        $session = Yii::$app->session;
        $session->open();
        $modelBasket = new ClassBasket();
        $modelBasket->removeProduct($id);

        $this->layout = false;
        return $this->render('cart-modal', ['session'=>$session]);
    }
    public function actionGetCountProduct(){
        $session = Yii::$app->session;
        $session->open();
        return (isset($session['basket']) ? count($session['basket']) : 0).' товаров на сумму '.number_format(isset($session['basket.sum']) ? $session['basket.sum'] : 0, 0, '', ' ').' руб.';
    }

    public function actionShow(){
        $session = Yii::$app->session;
        $session->open();
        $this->layout = false;
        return $this->render('cart-modal', ['session'=>$session]);
    }

    public function actionOrder(){
        $session = Yii::$app->session;
        if(!isset($session['basket'])){
            echo 'Ваша корзина пуста. Вам необходимо добавить товары в корзину!';
            return false;
        }

        $modelOrder = new ModelOrder();

        return $this->render('cart-order',['modelOrder'=>$modelOrder]);
    }

    public function actionConfirmOrder(){

        $jsonResult = '';

        $post = Yii::$app->request->post();

        $session = Yii::$app->session;
        $session->open();
        $userHashId = uniqid();


        if(!isset($_SESSION['basket'])){
            $session->setFlash('accept-order', '{"TYPE":"ERROR", "MSG":"Извините, но время оформления заказа истекло. Вам будет необходимо добавить заново все товры в корзину и повторить заказ."}');

            return $this->redirect(['basket/cart-finish',
                'userHashId'=>$userHashId,
            ]);
        }

        $modelOrder = new ModelOrder();
        $modelOrder->user_hash = $userHashId;
        $modelOrder->product_id = 0;
        $modelOrder->accept_politics = 1;

        $arrayListOrder = [];


        if($modelOrder->load($post)){

            if($modelOrder->validate()) {

                // Send to EMail

                $messageEmail = '<table style="border-collapse: collapse; text-align: left;">';
                    $messageEmail .= "<caption style='padding-bottom: 10px; font-size: 22px;'>Новый заказ №: <span style=\"color: #F50000;font-weight: bold;\">{$userHashId}</span></caption>";
                    $messageEmail .= "<tr><th style='padding: 5px; border: dashed 1px #F50000;'>Ф.И.О: </th><td style='padding: 5px; border: dashed 1px #F50000;'>{$modelOrder->fio}</td></tr>";
                    $messageEmail .= "<tr><th style='padding: 5px; border: dashed 1px #F50000;'>Телефон: </th><td style='padding: 5px; border: dashed 1px #F50000;'>{$modelOrder->phone}</td></tr>";
                    $messageEmail .= "<tr><th style='padding: 5px; border: dashed 1px #F50000;'>Страна: </th><td style='padding: 5px; border: dashed 1px #F50000;'>{$modelOrder->country}</td></tr>";
                    $messageEmail .= "<tr><th style='padding: 5px; border: dashed 1px #F50000;'>Город: </th><td style='padding: 5px; border: dashed 1px #F50000;'>{$modelOrder->town}</td></tr>";
                    $messageEmail .= "<tr><th style='padding: 5px; border: dashed 1px #F50000;'>Улица: </th><td style='padding: 5px; border: dashed 1px #F50000;'>{$modelOrder->street}</td></tr>";
                    $messageEmail .= "<tr><th style='padding: 5px; border: dashed 1px #F50000;'>Почтовый индекс: </th><td style='padding: 5px; border: dashed 1px #F50000;'>{$modelOrder->post_index}</td></tr>";
                    $messageEmail .= "<tr><th style='padding: 5px; border: dashed 1px #F50000;'>email: </th><td style='padding: 5px; border: dashed 1px #F50000;'>{$modelOrder->email}</td></tr>";
                    $messageEmail .= "<tr><th style='padding: 5px; border: dashed 1px #F50000;'>Коментарий: </th><td style='padding: 5px; border: dashed 1px #F50000;'>{$modelOrder->description}</td></tr>";
                $messageEmail .= '</table>';


                $messageEmail .= '<table style="border-collapse: collapse; text-align: left; margin-top:50px;">';
                $messageEmail .= "<tr><th style='padding: 5px; border: dashed 1px #F50000;'>ИД товара</th><th style='padding: 5px; border: dashed 1px #F50000;'>Изображение</th><th style='padding: 5px; border: dashed 1px #F50000;'>Название продукта / параметры</th><th style='padding: 5px; border: dashed 1px #F50000;'>Кол-во</th><th style='padding: 5px; border: dashed 1px #F50000;'>Цена</th></tr>";
                foreach($session['basket'] as $id => $item){
                    $messageEmail .= '<tr>';
                        $messageEmail .= '<td style="padding: 5px; border: dashed 1px #F50000;">'.$id.'</td>';
                        $messageEmail .= '<td style="padding: 5px; border: dashed 1px #F50000;"><img height="50" src="'.explode('/',$_SERVER['SERVER_PROTOCOL'])[0].'://'.$_SERVER['HTTP_HOST'].$item['image'].'" /></td>';
                        $messageEmail .= '<td style="padding: 5px; border: dashed 1px #F50000;">';
                        $messageEmail .= '<a href="'.(Url::to(['site/product','id'=>$id], true)).'" target="_blank">'.$item['title'].'</a>';
                        $messageEmail .= '<ul style="list-style: none; font-size: 12px;">';
                                $strParams = '';
                                foreach($item['params'] as $i => $param){
                                    $strParams .= "{$param['title']}: {$param['values']} {$param['unit']} | ";
                                    $messageEmail .= "<li>{$param['title']}: {$param['values']} {$param['unit']}</li>";
                                }
                        $messageEmail .= '</ul>';
                        $messageEmail .= '</td>';
                        $messageEmail .= '<td style="padding: 5px; border: dashed 1px #F50000;">'.$item['count'].'</td>';
                        $messageEmail .= '<td style="padding: 5px; border: dashed 1px #F50000;">'.$item['price']*$item['count'].' руб.<div style="">'.$item['price'].' руб. за 1 ед.</div></td>';
                    $messageEmail .= '</tr>';

                    $arrayListOrder[] = [
                        $id,
                        $modelOrder->fio,
                        $modelOrder->country,
                        $modelOrder->town,
                        $modelOrder->street,
                        $modelOrder->phone,
                        $modelOrder->post_index,
                        $modelOrder->email,
                        $modelOrder->description,
                        $strParams,
                        $item['count'],
                        $item['price'],
                        //'price_pay',
                        1,
                        'ОФОРМЛЕН, НО НЕ ОПЛАЧЕН',
                        $userHashId
                    ];

                }
                $messageEmail .= '<tr><td colspan="5" style="padding: 5px; border: dashed 1px #F50000; font-weight: bold;">Общее кол-во товара: '.$_SESSION['basket.count'].'</td><tr>';
                $messageEmail .= '<tr><td colspan="5" style="padding: 5px; border: dashed 1px #F50000; font-weight: bold;">Общая сумма к оплате: '.$_SESSION['basket.sum'].' руб.</td></tr>';
                $messageEmail .= '</table>';


                // Send to TELEGRAM

                $messageTelegram = '┏━━━━━━━━━━━━━━━┓ %0A';
                $messageTelegram .= 'Номер заказа №: '.$userHashId;
                $messageTelegram .= 'Ф.И.О: ' . $modelOrder->fio . '%0A';
                $messageTelegram .= 'Телефон: ' . $modelOrder->phone . '%0A';
                //$messageTelegram .= 'Страна: ' . $modelOrder->country . '%0A';
                //$messageTelegram .= 'Город: ' . $modelOrder->town. '%0A';
                //$messageTelegram .= 'Улица: ' . $modelOrder->street . '%0A';
                //$messageTelegram .= 'Почтовый индекс: ' . $modelOrder->post_index . '%0A';
                //$messageTelegram .= 'email: ' . $modelOrder->email . '%0A';
                //$messageTelegram .= 'Коментарий: ' . $modelOrder->description . '%0A';
                //$messageTelegram .= '┣━━━━━━━━━━━━ товар ━━━━━━━━━━━┫ %0A';

                foreach($session['basket'] as $id => $item){
                    //$messageTelegram .= '<b>ИД товара: </b>'.$id.'%0A';
                    //$messageTelegram .= '<b>Продукт: </b>'.$item['title'].'%0A';
                    //$messageTelegram .= '<b>Картинка: </b>'.Yii::$app->homeUrl.'/'.$item['image'].'%0A';
                    //$messageTelegram .= '<b>Кол-во: </b>'.$item['count'].'%0A';
                    //$messageTelegram .= 'Выбранные пораметры: %0A';
                    foreach($item['params'] as $i => $param){
                        //$messageTelegram .= $i.') '.$param['values'].' '.$param['unit'].'%0A';
                    }
                }
                //$messageTelegram .= '┣━━━━━━━ Общая статистика ━━━━━━━┫ %0A';
                //$messageTelegram .= '<b>Общее кол-во: </b>'.$session['basket.count'].'%0A';
                $messageTelegram .= 'Общая сумма: '.$session['basket.sum'].' руб.%0A';
                $messageTelegram .= '┗━━━━━━━━━━━━━━━┛ %0A';


                ClassSendOrder::sendMessageTelegram($messageTelegram);
                $isSendMailToMagazine = ClassSendOrder::sendMessageToMail('milongashop@mail.ru','Новый заказ', $messageEmail, 'milongashop@mail.ru'); // при успеха - false;
                $isSendMailToUser = ClassSendOrder::sendMessageToMail($modelOrder->email,'Новый заказ', $messageEmail, 'milongashop@mail.ru');



                if($countInserts = Yii::$app->db->createCommand()->batchInsert('orders',[
                    'product_id',
                    'fio',
                    'country',
                    'town',
                    'street',
                    'phone',
                    'post_index',
                    'email',
                    'description',
                    'description_params',
                    'product_count',
                    'price',
                    //'price_pay',
                    'accept_politics',
                    'status_order',
                    'user_hash'
                ],$arrayListOrder)->execute() > 0){
                    if($isSendMailToMagazine && $isSendMailToUser){
                        $session->setFlash('accept-order', '{"TYPE":"SUCCESS", "MSG":"Заказ принят!", "CODE-ORDER":"'.$modelOrder->user_hash.'"}');
                    }else{
                        if(!$isSendMailToMagazine){
                            $session->setFlash('accept-order', '{"TYPE":"SUCCESS", "MSG":"Заказ принят - I!", "CODE-ORDER":"'.$userHashId.'"}');
                        }else if($isSendMailToUser){
                            $session->setFlash('accept-order', '{"TYPE":"SUCCESS", "MSG":"Заказ принят - II!", "CODE-ORDER":"'.$userHashId.'"}');
                        }
                    }
                    ClassBasket::clearBasket();
                }else{
                    if(!$isSendMailToMagazine || !$isSendMailToUser){
                        $session->setFlash('accept-order', '{"TYPE":"ERROR", "MSG":"Заказ НЕ принят! Внутреняя ошибка", "CODE-ORDER":""}');
                    }else{
                        $session->setFlash('accept-order', '{"TYPE":"ERROR", "MSG":"Заказ принят!", "CODE-ORDER":"'.$userHashId.'"}');
                    }

                }
            }else{
                $session->setFlash('accept-order', '{"TYPE":"ERROR", "MSG":"Ваша заяка - не принята. Возможно Вы вели не коректо данные."}');
            }
            //var_dump($modelOrder->errors);
        }

        return $this->redirect(['basket/cart-finish',
            'userHashId'=>$userHashId,
        ]);
    }

    public function actionCartFinish($userHashId){
        $session = Yii::$app->session;
        $session->open();
        $jsonResult = $session->hasFlash('accept-order') ? json_decode($session->getFlash('accept-order'), true) : [];
        $arrayListOrder = ModelOrder::find()->with('oneProduct')->where(['user_hash'=>$userHashId])->asArray()->all();
        /*ModelOrder::find()->select('orders.*')->leftJoin('products p','p.id = orders.product_id')->where('orders.user_hash=:userHash', [':userHash' => $userHashId])->asArray()->all();*/

        //print_r($arrayListOrder);
        return $this->render('cart-finish',[
            'userHashId'=>$userHashId,
            'session'=>$session,
            'jsonResult'=>$jsonResult,
            'arrayListOrder'=>$arrayListOrder
        ]);
    }
}
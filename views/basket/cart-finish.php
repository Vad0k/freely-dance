<?php
use yii\helpers\Url;

$arrayResult = $jsonResult;
//var_dump($arrayListOrder);
$totalSumPriceProducts = 0;
$totalCountPriceProducts = 0;
?>
<article class="article">
        <h1>ЗАЯВКА ОФОРМЛЕНА</h1>

        <p>Ваш <span class="bold">заказ принят (№ <span style="color:#F50000;"><?=$arrayListOrder[0]['user_hash']?></span>)</span> и оформлен на <?=$arrayListOrder[0]['fio']?> и в дальнейшем будет доставлен по адресу: <?=$arrayListOrder[0]['country']?>, <?=$arrayListOrder[0]['town']?>, <?=$arrayListOrder[0]['street']?>, <?=$arrayListOrder[0]['post_index']?></p>
        <?php if(!empty($arrayListOrder[0]['description'])):?>
            <p>Ваше примечание к заказу: <?=$arrayListOrder[0]['description']?></p>
        <?php endif;?>


        <div class="table-responsive">
            <table class="table-default table-hover">
                <tr>
                    <th>#</th>
                    <th>Изображение</th>
                    <th>Название товара</th>
                    <th>Кол-во</th>
                    <th>Цена</th>
                    <th>Статус заказа</th>
                </tr>

                <?php foreach($arrayListOrder as $i => $item):?>
                    <?php
                        $totalSumPriceProducts += $item['price'] * $item['product_count'];
                        $totalCountPriceProducts += $item['product_count'];
                    ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><img src="<?=$item['oneProduct']['image']?>" alt="<?=$item['oneProduct']['title']?>" height="80"></td>
                        <td><a href="<?=Url::to(['site/product','id'=>$item['product_id']])?>"><?=$item['oneProduct']['title']?></a></td>
                        <td><?=$item['product_count']?></td>
                        <td><?=number_format($item['price']*$item['product_count'],0,'',' ')?><div style="font-size: 12px;"><?=number_format($item['price'],0,'',' ')?> руб. за ед.</div></td>
                        <td><?=$item['status_order']?></td>
                    </tr>
                <?php endforeach;?>

                <tr>
                    <td colspan="3">Итого: </td>
                    <td><?=$totalCountPriceProducts?> шт.</td>
                    <td><?=number_format($totalSumPriceProducts,0,'',' ')?> руб.</td>
                    <td>

                    </td>
                </tr>
            </table>
            <br />
            <br />
            <span class="bold" style="color: #F50000; text-align: center;display: block;">Пожалуйста, перед оплатой товара, уточните его наличие на складе по телефону:<br />+7 (978) 737-74-40 !!!</span>
            <br />

            <form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml">
                <input type="hidden" name="receiver" value="410015461793394">
                <input type="hidden" name="formcomment" value="<?=("№ $userHashId - ФИО: {$arrayListOrder[0]['fio']}")?>">
                <input type="hidden" name="short-dest" value="<?=("№ $userHashId - ФИО: {$arrayListOrder[0]['fio']}")?>">
                <input type="hidden" name="label" value="<?=$userHashId?>">
                <input type="hidden" name="quickpay-form" value="shop">
                <input type="hidden" name="targets" value="Транзакция: № <?=$userHashId?>">
                <input type="hidden" name="sum" value="<?=$totalSumPriceProducts?>" data-type="number">
                <input type="hidden" name="comment" value="<?='Заказ № '.$arrayListOrder[0]['user_hash']?>. ФИО: <?=$arrayListOrder[0]['fio']?>">
                <input type="hidden" name="need-fio" value="false">
                <input type="hidden" name="need-email" value="false">
                <input type="hidden" name="need-phone" value="false">
                <input type="hidden" name="need-address" value="false">
                <label><input type="radio" name="paymentType" value="PC">Яндекс.Деньгами</label>
                <label><input type="radio" name="paymentType" value="AC" chec>Банковской картой</label>
                <input type="submit" value="Перейти к оплате!" class="btn btn-success bold">
            </form>

        </div>



</article>
<style>
    .table-default{
        text-align: left;
        font-size: 16px;
        border-collapse: collapse;
    }
    .table-default tr td{
        vertical-align: middle;
    }
</style>



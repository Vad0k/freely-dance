<?php

?>
<?php use yii\helpers\Url;

if(isset($session['basket'])):?>
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Фото</th>
                <th>Наименование</th>
                <th>Кол-во</th>
                <th>Цена</th>
                <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($session['basket'] as $id => $item):?>
            <tr>
                <td><img src="<?=$item['image']?>" alt="<?=$item['title']?>" height="50"/></td>
                <td>
                    <a href="<?=Url::to(['site/product','id'=>$id])?>"><?=$item['title']?></a>
                    <?php if(!empty($item['params'])):?>
                        <ul class="parmas">
                            <?php $arrayListParams = $item['params']; ?>
                            <?php foreach($arrayListParams as $param):?>
                            <li><span><?=$param['title']?>: </span><?=$param['values'].' '.$param['unit']?></li>
                            <?php endforeach;?>
                        </ul>
                    <?php endif;?>
                </td>
                <td><?=$item['count']?></td>
                <td>
                    <?=number_format($item['price'] * $item['count'],0,'',' ')?> руб.
                    <div style="font-size: 12px;">(<?=number_format($item['price'],0,'', ' ')?> руб. за 1 ед.)</div>
                </td>
                <td><span class="glyphicon glyphicon-remove text-danger del-product" aria-hidden="true" data-id="<?=$id?>" data-href="<?=Url::to(['basket/remove-product','id'=>$id])?>"></span></td>
            </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="4">Итого: </td>
                <td><?=$session['basket.count']?></td>
            </tr>
            <tr>
                <td colspan="4">На сумму: </td>
                <td><?=number_format($session['basket.sum'],0,'',' ')?> руб.</td>
            </tr>
        </tbody>
    </table>

</div>
<?php else:?>
    <h3>Корзина пуста</h3>
<?php endif?>

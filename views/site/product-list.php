<?php
use yii\helpers\Url;

for($i = count($arrayAllStepNav)-1; $i >=0; $i--){
    foreach($arrayAllNavLeft as $item){
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
                $this->params['breadcrumbs'][] = ['label' => $item['label'], 'url' => $url];
            }else{
                $this->params['breadcrumbs'][] = $item['label'];
            }

            break;
        }
    }
}
?>
<main id="product-list" class="main">
    <h1 class="title-section"><?=$itemCategory['label']?></h1>
    <?php if(!empty($itemCategory['article'])):?>
        <div class="article"><?=$itemCategory['article']?></div>
    <?php else:?>
        <div></div>
    <?php endif?>
    <nav class="list">
    <?php foreach($arrayListProduct as $item):?>
        <a href="<?=Url::to(['site/product','id'=>$item['id']])?>" class="item">
            <div class="icon" style="background-image: url('<?=$item['image']?>')<?=!empty($item['bgSize']) ? ';background-size:'.$item['bgSize']:''?><?=!empty($item['bgPosition'])?';background-position:'.$item['bgPosition'].';':''?>">
                <div class="box">
                    <small class="price"><?php if($item['price'] > 0):?>Цена: <?=number_format($item['price'],0,'',' ')?> руб.<?php else:?>Цену уточняйте<?php endif;?></small>
                    <small class="code">код: <?=$item['product_code']?></small>
                </div>
            </div>
            <h2 class="title"><?=$item['title']?></h2>
        </a>
    <?php endforeach;?>
    </nav>
</main>

<script>
	document.onload = function(){
		console.log('Scroll');
		var article = $('.article').offsetTop() + $('.article').height();
		$("html, body").animate({ scrollTop: article }, 300);
	}
</script>


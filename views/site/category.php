<?php

use app\models\ClassBreadCrumbs;
use yii\helpers\Url;

//$this->params['breadcrumbs'][] = $itemCategory['label'];

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

<main id="index-category" class="main">
    <h1 class="title-section"><?=$itemCategory['label']?></h1>

    <nav class="list">
    <?php foreach($arrayCategory as $item):?>
        <a href="<?=(strcasecmp($item['type'], 'PRODUCT') === 0 ? Url::to(['site/product-list','id'=>$item['id']]) : Url::to(['site/category','id'=>$item['id']]))?>" class="item">
            <div class="icon" style="background-image: url('<?=$item['image']?>');<?=!empty($item['position']) ? ' background-position:'.$item['position'].';':''?><?=!empty($item['bgSize']) ? ' background-size:'.$item['bgSize'].';': ''?>">
                <div class="box"></div>
            </div>
            <h2 class="title"><?=$item['label']?></h2>
        </a>
    <?php endforeach?>
    </nav>

    <?php if(!empty($itemCategory['article'])):?>
        <div class="article"><?=$itemCategory['article']?></div>
    <?php endif?>

</main>
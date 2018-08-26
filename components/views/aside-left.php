<?php
use yii\helpers\Url;

$isFirst = true;
foreach($arrayIdRoots as $id){
    foreach($arrayListMenuNav as $item){
        if($id == $item['id']){
            if($isFirst){
                $isFirst = false;
                $this->params['breadcrumbs'][] = $item['label'];
            }

            $url = null;
            if ($item['type'] == 'CATEGORY') {
                $url = Url::to(['site/category','id'=>$item['id']]);
            } else if ($item['type'] == 'SUB-CATEGORY') {
                $url = Url::to(['site/category','id'=>$item['id']]);
            } else if ($item['type'] == 'PRODUCT') {
                $url = Url::to(['site/product-list','id'=>$item['id']]);
            } else if ($item['type'] == 'PAGE'){
                $url = Url::to([$item['url']]);
            }else {
                $url = '/';
            }

            $this->params['breadcrumbs'][] = ['label' => $item['label'], 'url' => $url];
        }
    }
}
?>

<aside id="menu-left">
    <?=$HTML_MenuAsideLeft?>
</aside>

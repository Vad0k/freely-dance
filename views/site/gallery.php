<?php
use yii\widgets\LinkPager;

$this->params['breadcrumbs'][] = 'Галерея';
?>
<article class="article">
    <h1 class="title-section" style="display: block; color:">Галерея</h1>
    <?php foreach($arrayListGallery as $item):?>
        <div class="col-sm-6 col-md-4 col-lg-4">
            <a href="#" class="thumbnail">
                <img src="<?=$item['image']?>" alt="<?=$item['alt']?>">
            </a>
        </div>
    <?php endforeach;?>

    <?= LinkPager::widget([
        'pagination' => $pages,
    ]);
    ?>
    <div class="clear"></div>
</article>


<div class="modal fade" id="gallery-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <div class="modal-title">Просмотр изображения</div>
            </div>
            <div class="modal-body">
                <img class="img-responsive center-block" src="" alt="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
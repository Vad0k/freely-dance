$('#section-header-slider').mobilyslider({
    content: '.slider', // селектор для слайдера
    children: 'li', // селектор для дочерних элементов
    transition: 'fade', // переходы: horizontal, vertical, fade
    animationSpeed: 1200, // скорость перехода в миллисекундах
    autoplay: true,
    autoplaySpeed: 4000, // время между переходами (миллисекунды)
    pauseOnHover: false, // останавливать навигацию при наведении на слайдер: false, true
    bullets: false, // генерировать навигацию (true/false, class: sliderBullets)
    arrows: false, // генерировать стрелки вперед и назад (true/false, class: sliderArrows)
    arrowsHide: true, // показывать стрелки только при наведении
    prev: 'prev', // название класса для кнопки назад
    next: 'next', // название класса для кнопки вперед
    animationStart: function(){}, // вызывать функцию при старте перехода
    animationComplete: function(){} // вызывать функцию когда переход завершен
});

function getProductParams(){
    var arraySelectParams = $('#product-description select[data-type="select-params"]');
    var dataProductParams = {};
    for(var i = 0; i < arraySelectParams.length; i++){
        var idParam = $(arraySelectParams[i]).data('id');
        dataProductParams[idParam] = $(arraySelectParams[i]).val();
    }
    console.log(JSON.stringify(dataProductParams));
    return dataProductParams;
}
function getBasketCountProducts(){
    var countBasket = $('#header .basket .count');
    $.get($(countBasket).data('url'), function(result){
        $(countBasket).text(result);
    });
}

//Отобразить корзину
$(document).on('click','#header .basket', function(e) {
    e.preventDefault();
    console.log('basket');
    $.ajax({
        type:'get',
        url:$(this).attr('href'),
        success:function(result){
            $('#basket-cart .modal-body').html(result);
            $('#basket-cart').modal();
            getBasketCountProducts();
        }
    });
});
//Добавить в корзину товар в разделе описания товара
$(document).on('click','#product-description .btn-add-basket', function(e) {
    e.preventDefault();
    var dataProductParams = getProductParams();
    console.log('dataProductParams = '+JSON.stringify(dataProductParams) + ' url = '+$(this).attr('href'));
    $.ajax({
        type: 'get',
        url: $(this).attr('href') + '&params=' + JSON.stringify(dataProductParams),
        success: function (result) {
            console.log(result);
            $('#basket-cart .modal-body').html(result);
            $('#basket-cart').modal();
            getBasketCountProducts();
        }
    });
});
// удалить один пункт в корзине
$(document).on('click','#basket-cart .del-product', function(){
    console.log('click del-product');
    $.ajax({
        type: 'get',
        url: $(this).data('href') + '&id=' + $(this).data('id'),
        success: function (result) {
            $('#basket-cart .modal-body').html(result);
            $('#basket-cart').modal();
            getBasketCountProducts();
        }
    });
});
$(document).on('click', '#basket-cart .clear-basket', function(e){
    e.preventDefault();
    $.ajax({
        type: 'get',
        url: $(this).attr('href'),
        success: function (result) {
            $('#basket-cart .modal-body').html(result);
            $('#basket-cart').modal();
            getBasketCountProducts();
        }
    });
});

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip()
});
$(document).on('change','#product-description #select-chose-product',function(){
    location.href=$(this).data('url')+$(this).val();
});

$(document).on('click', '#footer .scroll-up', function(){
    $("html, body").stop().animate({ scrollTop: 0 }, 600);
    return false;
});

$(document).on('submit', '#form-get-contacts', function(e){
    e.preventDefault();
    $.ajax({
        type:'post',
        url:$(this).attr('action'),
        data:$(this).serialize(),
        success:function(result){
            $('#simple-alert .modal-body').html(result);
            $('#simple-alert').modal();
        }
    });
});

//открыть галерею
$(document).on('click', 'a.thumbnail', function(e) {
    e.preventDefault();
    $('#gallery-modal .modal-body img').attr('src', $(this).find('img').attr('src'));
    $("#gallery-modal").modal('show');
});
//закрыть галерею
$(document).on('click', '#gallery-modal .modal-body img', function() {
    $("#gallery-modal").modal('hide')
});
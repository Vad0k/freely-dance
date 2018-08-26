<?php

namespace app\controllers;

use app\models\MenuHelper;
use app\models\ModelGallery;
use app\models\ModelGetContacts;
use app\models\ModelParams;
use Yii;
use app\models\ModelCategory;
use app\models\ModelProducts;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class SiteController extends Controller{

    public function actionIndex(){
        $this->layout = 'template-index';
        $modelCategory = new ModelCategory();
        $arrayListCategory = $modelCategory->find()->where(['parent_id'=>0, 'visible'=>1])->orderBy(['parent_id'=>SORT_ASC,'sort'=>SORT_ASC])->asArray()->all();

        if(empty($arrayListCategory)){
            throw new NotFoundHttpException;
        }

        // META TAGS
        $this->view->title = 'Интернет магазин нарядкница - всё для танцев в Симферополе';
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Самый большой магазин для танцев в Симферополе. Вы можете у Нас купить или заказать на индивидуальный пошив или даже взять в аренду одежду для выступления.']);
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Нарядница, одежда для танцев, индивидуальный пошив']);

        // Open Graph Tags
        $this->view->registerMetaTag(['property'=>'og:title', 'content'=> 'Интернет магазин нарядкница - всё для танцев в Симферополе']);
        $this->view->registerMetaTag(['property'=>'og:description', 'content'=> '']);
        $this->view->registerMetaTag(['property'=>'og:image', 'content'=> Yii::getAlias('@web/images/logo_600x667.png')]);
        $this->view->registerMetaTag(['property'=>'og:image:width', 'content'=> '600']);
        $this->view->registerMetaTag(['property'=>'og:image:height', 'content'=> '667']);
        $this->view->registerMetaTag(['property'=>'og:url', 'content'=> Yii::$app->request->absoluteUrl]);
        $this->view->registerMetaTag(['property'=>'og:type', 'content'=>'website']);
        $this->view->registerMetaTag(['property'=>'og:site_name', 'content'=>'Милонга']);

        return $this->render('index',[
            'arrayListCategory'=>$arrayListCategory
        ]);
    }

    public function actionCategory($id){
        if(is_numeric($id)){

            $modelCategory = new ModelCategory();
            $itemCategory = $modelCategory->findOne(['id'=>$id]);
            $arrayCategory = $modelCategory->find()->where(['parent_id'=>$id,'visible'=>1])->orderBy(['sort'=>SORT_ASC])->asArray()->all();

            if(empty($arrayCategory)){
                throw new NotFoundHttpException('Категория пустая');
            }

            $arrayAllNavLeft = $modelCategory->findAll(['visible'=>1]);
            $arrayAllStepNav = MenuHelper::getArrayIdParents($arrayAllNavLeft, $id);

            $head_title = !empty($itemCategory['head_title']) ? $itemCategory['head_title'] : 'Купить '.$itemCategory['label'].' в Симферополе, Крыму.';
            $head_description = !empty($itemCategory['head_description']) ? $itemCategory['head_description'] : "Купить {$itemCategory['label']} по доступным ценам, Вам надо обратиться в наш интернет магазин Милонга. Будем рады видеть вас у нас в городе Симферополь";
            $head_keywords = !empty($itemCategory['head_keywords']) ? $itemCategory['head_keywords'] : $head_title;


            // META TAGS
            $this->view->title = $head_title;
            $this->view->registerMetaTag(['name' => 'description', 'content' => $head_description]);
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $head_keywords]);

            // Open Graph Tags
            $this->view->registerMetaTag(['property'=>'og:title', 'content'=> $head_title]);
            $this->view->registerMetaTag(['property'=>'og:description', 'content'=> $head_description]);
            $this->view->registerMetaTag(['property'=>'og:image', 'content'=> $itemCategory['image']]);
            $this->view->registerMetaTag(['property'=>'og:image:width', 'content'=> '512']);
            $this->view->registerMetaTag(['property'=>'og:image:height', 'content'=> '512']);
            $this->view->registerMetaTag(['property'=>'og:url', 'content'=> Yii::$app->request->absoluteUrl]);
            $this->view->registerMetaTag(['property'=>'og:type', 'content'=>'website']);
            $this->view->registerMetaTag(['property'=>'og:site_name', 'content'=>'Милонга']);

            return $this->render('category',[
                'arrayCategory'=>$arrayCategory,
                'itemCategory'=>$itemCategory,
                'id'=>$id,
                'arrayAllNavLeft' =>$arrayAllNavLeft, //вся левая навигация
                'arrayAllStepNav' =>$arrayAllStepNav // список id от ребенка к корню.
            ]);
        }
        return $this->redirect('error',404);
    }

    public function actionProductList($id){
        if(is_numeric($id)){
            $modelCategory = new ModelCategory();
            $itemCategory = $modelCategory->findOne(['id'=>$id, 'visible'=>1]);

            $modelProduct = new ModelProducts();
            $arrayListProduct = $modelProduct->find()->where(['category_id'=>$id, 'isVisible'=>1])->asArray()->all();

            if(empty($arrayListProduct)){
                throw new NotFoundHttpException;
            }

            $arrayAllNavLeft = $modelCategory->findAll(['visible'=>1]);
            $arrayAllStepNav = MenuHelper::getArrayIdParents($arrayAllNavLeft, $id);

            $head_title = !empty($itemCategory['head_title']) ? $itemCategory['head_title'] : 'Купить '.$itemCategory['label'].' в Симферополе, Крыму.';
            $head_description = !empty($itemCategory['head_description']) ? $itemCategory['head_description'] : "Купить {$itemCategory['label']} по доступным ценам, Вам надо обратиться в наш интернет магазин Милонга. Будем рады видеть вас у нас в городе Симферополь";
            $head_keywords = !empty($itemCategory['head_keywords']) ? $itemCategory['head_keywords'] : $head_title;

            // META TAGS
            $this->view->title = $head_title;
            $this->view->registerMetaTag(['name' => 'description', 'content' => $head_description]);
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $head_keywords]);

            // Open Graph Tags
            $this->view->registerMetaTag(['property'=>'og:title', 'content'=> $head_title]);
            $this->view->registerMetaTag(['property'=>'og:description', 'content'=> $head_description]);
            $this->view->registerMetaTag(['property'=>'og:image', 'content'=> $itemCategory['image']]);
            $this->view->registerMetaTag(['property'=>'og:image:width', 'content'=> '512']);
            $this->view->registerMetaTag(['property'=>'og:image:height', 'content'=> '512']);
            $this->view->registerMetaTag(['property'=>'og:url', 'content'=> Yii::$app->request->absoluteUrl]);
            $this->view->registerMetaTag(['property'=>'og:type', 'content'=>'website']);
            $this->view->registerMetaTag(['property'=>'og:site_name', 'content'=>'Милонга']);


            return $this->render('product-list',[
                'arrayListProduct'=>$arrayListProduct,
                'itemCategory'=>$itemCategory,
                'id'=>$id,
                'arrayAllNavLeft' =>$arrayAllNavLeft, //вся левая навигация
                'arrayAllStepNav' =>$arrayAllStepNav // список id от ребенка к корню.
            ]);
        }
        return $this->redirect('error',404);
    }

    public function actionProduct($id){
        if(is_numeric($id)){
            $modelCategory = new ModelCategory();
            $itemCategory = $modelCategory->findOne(['id'=>$id]);

            $modelProduct = new ModelProducts();
            $itemProduct = $modelProduct->findOne(['id'=>$id, 'isVisible'=>1]);
            $arrayProduct = $modelProduct->find()->where(['category_id'=>$itemProduct['category_id']])->orderBy(['sort'=>SORT_ASC])->asArray()->all();

            $arrayAllNavLeft = $modelCategory->findAll(['visible'=>1]);
            $arrayAllStepNav = MenuHelper::getArrayIdParents($arrayAllNavLeft, $itemProduct['category_id']);

            if(empty($itemProduct)){
                throw new NotFoundHttpException;
            }

            $arrayWords = explode(' ',trim($itemProduct['title']));
            $lengthArrayWords = count($arrayWords);
            $arrayWords = $lengthArrayWords > 0 ? trim($arrayWords[$lengthArrayWords-1]):'Vad0k';
            $arrayListSimilar = $modelProduct->find()->where(['AND', ['not', ['category_id'=> $itemProduct['category_id']]], ['OR LIKE', 'title', $arrayWords]])->andWhere(['isVisible'=>1])->asArray()->all();

            $arrayListProductParams = ModelParams::find()->where(['in','id', json_decode($itemProduct['params'])])->asArray()->all();


            $head_title = !empty($itemProduct['head_title']) ? $itemProduct['head_title'] : 'Купить '.$itemProduct['title'].' в Симферополе, Крыму.';
            $head_description = !empty($itemProduct['head_description']) ? $itemProduct['head_description'] : "В интернет магазине Милонга вы можете купить {$itemProduct['title']} в Симферополе по лучшим ценам в Крыму. Мы можем сделать вам лучшее предложение среди всех!";
            $head_keywords = !empty($itemProduct['head_keywords']) ? $itemProduct['head_keywords'] : $head_title;

            // META TAGS
            $this->view->title = $head_title;
            $this->view->registerMetaTag(['name' => 'description', 'content' => $head_description]);
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $head_keywords]);

            // Open Graph Tags
            $this->view->registerMetaTag(['property'=>'og:title', 'content'=> $head_title]);
            $this->view->registerMetaTag(['property'=>'og:description', 'content'=> $head_description]);
            $this->view->registerMetaTag(['property'=>'og:image', 'content'=> $itemProduct['image']]);
            $this->view->registerMetaTag(['property'=>'og:image:width', 'content'=> '512']);
            $this->view->registerMetaTag(['property'=>'og:image:height', 'content'=> '512']);
            $this->view->registerMetaTag(['property'=>'og:url', 'content'=> Yii::$app->request->absoluteUrl]);
            $this->view->registerMetaTag(['property'=>'og:type', 'content'=>'website']);
            $this->view->registerMetaTag(['property'=>'og:site_name', 'content'=>'Милонга']);

            return $this->render('product',[
                'itemProduct'=>$itemProduct,
                'itemCategory'=>$itemCategory,
                'arrayProduct'=>$arrayProduct,
                'id'=>$id,
                'arrayAllNavLeft' =>$arrayAllNavLeft, //вся левая навигация
                'arrayAllStepNav' =>$arrayAllStepNav, // список id от ребенка к корню.
                'arrayListSimilar'=>$arrayListSimilar, // список похожих товаров
                'arrayListProductParams' => $arrayListProductParams
            ]);
        }
        return $this->redirect('error',404);
    }

    public function actionArticle(){
        return $this->render('article');
    }
    public function actionHowMeasureShoes(){
        $head_title = 'Как измерить обувь? Купить обувь для танцев в Симферополе';
        $head_description = 'Вы можете измерить необходимый вам размер для обуви самостоятельно!Для этого мы написали подробную инструкцию,чтобы клиент не смог ошибиться при заказе!';
        $head_keywords = 'как измерить обувь';

        // META TAGS
        $this->view->title = $head_title;
        $this->view->registerMetaTag(['name' => 'description', 'content' => $head_description]);
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $head_keywords]);

        // Open Graph Tags
        $this->view->registerMetaTag(['property'=>'og:title', 'content'=> $head_title]);
        $this->view->registerMetaTag(['property'=>'og:description', 'content'=> $head_description]);
        $this->view->registerMetaTag(['property'=>'og:image', 'content'=> Yii::getAlias('@web/images/img-foot-measure-shoes.jpg')]);
        $this->view->registerMetaTag(['property'=>'og:image:width', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:image:height', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:url', 'content'=> Yii::$app->request->absoluteUrl]);
        $this->view->registerMetaTag(['property'=>'og:type', 'content'=>'website']);
        $this->view->registerMetaTag(['property'=>'og:site_name', 'content'=>'Милонга']);

        return $this->render('how-measure-shoes');
    }
    public function actionHowMeasurePointeShoes(){

        $head_title = 'Как подобрать (измерить) пуанты для танцев?';
        $head_description = 'На данной странице мы расскажем Вам, как правильно снять мерки для пуантов, чтобы вы не ошиблись при выборе товара!';
        $head_keywords = 'пуанты';

        // META TAGS
        $this->view->title = $head_title;
        $this->view->registerMetaTag(['name' => 'description', 'content' => $head_description]);
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $head_keywords]);

        // Open Graph Tags
        $this->view->registerMetaTag(['property'=>'og:title', 'content'=> $head_title]);
        $this->view->registerMetaTag(['property'=>'og:description', 'content'=> $head_description]);
        $this->view->registerMetaTag(['property'=>'og:image', 'content'=> Yii::getAlias('@web/images/logo_512.png')]);
        $this->view->registerMetaTag(['property'=>'og:image:width', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:image:height', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:url', 'content'=> Yii::$app->request->absoluteUrl]);
        $this->view->registerMetaTag(['property'=>'og:type', 'content'=>'website']);
        $this->view->registerMetaTag(['property'=>'og:site_name', 'content'=>'Милонга']);


        return $this->render('how-measure-pointe-shoes');
    }
    public function actionHowMeasureDress(){

        $head_title = 'Как измерить и подобрать одежду?';
        $head_description = 'Страница, посвященная ответу на вопрос-Как снять мерки правильно? Мы хотим облегчить процесс выбора одежды для нашего клиента!';
        $head_keywords = 'как измерить обувь';

        // META TAGS
        $this->view->title = $head_title;
        $this->view->registerMetaTag(['name' => 'description', 'content' => $head_description]);
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $head_keywords]);

        // Open Graph Tags
        $this->view->registerMetaTag(['property'=>'og:title', 'content'=> $head_title]);
        $this->view->registerMetaTag(['property'=>'og:description', 'content'=> $head_description]);
        $this->view->registerMetaTag(['property'=>'og:image', 'content'=> Yii::getAlias('@web/images/logo_512.png')]);
        $this->view->registerMetaTag(['property'=>'og:image:width', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:image:height', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:url', 'content'=> Yii::$app->request->absoluteUrl]);
        $this->view->registerMetaTag(['property'=>'og:type', 'content'=>'website']);
        $this->view->registerMetaTag(['property'=>'og:site_name', 'content'=>'Милонга']);

        return $this->render('how-measure-dress');
    }
    public  function actionDeliveryAndPayMethods(){

        $head_title = 'Доставка и оплата из магазина Милонга в Симферополе';
        $head_description = 'Здесь указаны условия доставки и оплаты. Клиент может ознакомиться с нашими условиями и выбрать оптимальный вариант для своей покупки';
        $head_keywords = 'доставка и оплата';

        // META TAGS
        $this->view->title = $head_title;
        $this->view->registerMetaTag(['name' => 'description', 'content' => $head_description]);
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $head_keywords]);

        // Open Graph Tags
        $this->view->registerMetaTag(['property'=>'og:title', 'content'=> $head_title]);
        $this->view->registerMetaTag(['property'=>'og:description', 'content'=> $head_description]);
        $this->view->registerMetaTag(['property'=>'og:image', 'content'=> Yii::getAlias('@web/images/logo_512.png')]);
        $this->view->registerMetaTag(['property'=>'og:image:width', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:image:height', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:url', 'content'=> Yii::$app->request->absoluteUrl]);
        $this->view->registerMetaTag(['property'=>'og:type', 'content'=>'website']);
        $this->view->registerMetaTag(['property'=>'og:site_name', 'content'=>'Милонга']);

        return $this->render('delivery-and-pay-methods');
    }
    public function actionContacts(){
        $head_title = 'Контакты';
        $head_description = 'Страница, на которой клиент сможет посмотреть необходимые контакты, для того,чтобы он смог связаться с нашим менеджером из магазина Милонга - Всё для танцев.';
        $head_keywords = 'контакты';

        // META TAGS
        $this->view->title = $head_title;
        $this->view->registerMetaTag(['name' => 'description', 'content' => $head_description]);
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $head_keywords]);

        // Open Graph Tags
        $this->view->registerMetaTag(['property'=>'og:title', 'content'=> $head_title]);
        $this->view->registerMetaTag(['property'=>'og:description', 'content'=> $head_description]);
        $this->view->registerMetaTag(['property'=>'og:image', 'content'=> Yii::getAlias('@web/images/logo_512.png')]);
        $this->view->registerMetaTag(['property'=>'og:image:width', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:image:height', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:url', 'content'=> Yii::$app->request->absoluteUrl]);
        $this->view->registerMetaTag(['property'=>'og:type', 'content'=>'website']);
        $this->view->registerMetaTag(['property'=>'og:site_name', 'content'=>'Милонга']);

        return $this->render('contacts');
    }
    public function actionBlankOrderSalonAtelye(){

        $head_title = 'Заказать индивидуальный пошив одежды для танцев в Симферополе';
        $head_description = 'На данной странице указан бланк заказа. Клиент сможет описать необходимое изделие или свойства товара, которые необходимы ему для танца!';
        $head_keywords = 'индивидуальный пошив';

        // META TAGS
        $this->view->title = $head_title;
        $this->view->registerMetaTag(['name' => 'description', 'content' => $head_description]);
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $head_keywords]);

        // Open Graph Tags
        $this->view->registerMetaTag(['property'=>'og:title', 'content'=> $head_title]);
        $this->view->registerMetaTag(['property'=>'og:description', 'content'=> $head_description]);
        $this->view->registerMetaTag(['property'=>'og:image', 'content'=> Yii::getAlias('@web/images/logo_512.png')]);
        $this->view->registerMetaTag(['property'=>'og:image:width', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:image:height', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:url', 'content'=> Yii::$app->request->absoluteUrl]);
        $this->view->registerMetaTag(['property'=>'og:type', 'content'=>'website']);
        $this->view->registerMetaTag(['property'=>'og:site_name', 'content'=>'Милонга']);

        return $this->render('page-blank-order-salon-atelye');
    }
    public function actionDiscount(){

        $head_title = 'Скидки';
        $head_description = 'Акционные товары!В данном разделе будут собраны все специальные предложения, для наших уважаемых и любимых клиентов!';
        $head_keywords = 'аукционный товар, скидки';

        // META TAGS
        $this->view->title = $head_title;
        $this->view->registerMetaTag(['name' => 'description', 'content' => $head_description]);
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $head_keywords]);

        // Open Graph Tags
        $this->view->registerMetaTag(['property'=>'og:title', 'content'=> $head_title]);
        $this->view->registerMetaTag(['property'=>'og:description', 'content'=> $head_description]);
        $this->view->registerMetaTag(['property'=>'og:image', 'content'=> Yii::getAlias('@web/images/logo_512.png')]);
        $this->view->registerMetaTag(['property'=>'og:image:width', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:image:height', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:url', 'content'=> Yii::$app->request->absoluteUrl]);
        $this->view->registerMetaTag(['property'=>'og:type', 'content'=>'website']);
        $this->view->registerMetaTag(['property'=>'og:site_name', 'content'=>'Милонга']);

        $arrayListProduct = ModelProducts::find()->where(['isFavorite'=>1])->asArray()->all();
        return $this->render('discount',
            ['arrayListProduct'=>$arrayListProduct]
        );
    }
    public function actionPrivacyPolicy(){ // политика конфедециальности

        $head_title = 'Политика конфедециальности | Милонга.';
        $head_description = 'В данном разделе описана политика конфедециальности, регулирующая основные положения взаимодействия с личными данными посетителей сайта';
        $head_keywords = 'Политика конфедециальности';

        // META TAGS
        $this->view->title = $head_title;
        $this->view->registerMetaTag(['name' => 'description', 'content' => $head_description]);
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $head_keywords]);

        // Open Graph Tags
        $this->view->registerMetaTag(['property'=>'og:title', 'content'=> $head_title]);
        $this->view->registerMetaTag(['property'=>'og:description', 'content'=> $head_description]);
        $this->view->registerMetaTag(['property'=>'og:image', 'content'=> Yii::getAlias('@web/images/logo_512.png')]);
        $this->view->registerMetaTag(['property'=>'og:image:width', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:image:height', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:url', 'content'=> Yii::$app->request->absoluteUrl]);
        $this->view->registerMetaTag(['property'=>'og:type', 'content'=>'website']);
        $this->view->registerMetaTag(['property'=>'og:site_name', 'content'=>'Милонга']);


        return $this->render('privacy-policy');
    }
    public function actionBuyOutOffer(){ // публичная оферта

        $head_title = 'Публичная оферта | Милонга';
        $head_description = 'Прочитайте нашу публичную оферту, в которой изложен основной порядок оплаты, покупки, возврата, обмена товара  и т.д.';
        $head_keywords = 'Публичная оферта';

        // META TAGS
        $this->view->title = $head_title;
        $this->view->registerMetaTag(['name' => 'description', 'content' => $head_description]);
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $head_keywords]);

        // Open Graph Tags
        $this->view->registerMetaTag(['property'=>'og:title', 'content'=> $head_title]);
        $this->view->registerMetaTag(['property'=>'og:description', 'content'=> $head_description]);
        $this->view->registerMetaTag(['property'=>'og:image', 'content'=> Yii::getAlias('@web/images/logo_512.png')]);
        $this->view->registerMetaTag(['property'=>'og:image:width', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:image:height', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:url', 'content'=> Yii::$app->request->absoluteUrl]);
        $this->view->registerMetaTag(['property'=>'og:type', 'content'=>'website']);
        $this->view->registerMetaTag(['property'=>'og:site_name', 'content'=>'Милонга']);

        return $this->render('buyout-offer');
    }
    public function actionGetContacts(){
        $model = new ModelGetContacts();
        if($model->load(Yii::$app->request->post()) && $model->validate()){

            echo 'Ваши контакты отправлены! Скоро мы с Вами свяжемся.';
            return;
        }
        echo 'Произошла ошибка. Ваши данные не отправлены';
    }
    public function actionGallery(){

        $head_title = 'Галерея';
        $head_description = 'В галерее вы сможете подробнее ознакомиться с нашим товаром. Здесь собраны самые лучшие варианты одежды для танцоров!';
        $head_keywords = 'галерея';

        // META TAGS
        $this->view->title = $head_title;
        $this->view->registerMetaTag(['name' => 'description', 'content' => $head_description]);
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $head_keywords]);

        // Open Graph Tags
        $this->view->registerMetaTag(['property'=>'og:title', 'content'=> $head_title]);
        $this->view->registerMetaTag(['property'=>'og:description', 'content'=> $head_description]);
        $this->view->registerMetaTag(['property'=>'og:image', 'content'=> Yii::getAlias('@web/images/logo_512.png')]);
        $this->view->registerMetaTag(['property'=>'og:image:width', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:image:height', 'content'=> '512']);
        $this->view->registerMetaTag(['property'=>'og:url', 'content'=> Yii::$app->request->absoluteUrl]);
        $this->view->registerMetaTag(['property'=>'og:type', 'content'=>'website']);
        $this->view->registerMetaTag(['property'=>'og:site_name', 'content'=>'Милонга']);

        $query = ModelGallery::find()->where(['visible' => 1]);
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 24,
            'pageSizeParam' => false, // убираем параметр page-per
            'forcePageParam' => false, // убираем на пагинации параметр page для первой страницы (SEO)
        ]);
        $arrayListGallery = $query->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        return $this->render('gallery', [
            'arrayListGallery' => $arrayListGallery,
            'pages' => $pages,
        ]);
    }

    public function actionError(){
        $exception = Yii::$app->errorHandler->exception;
        if ($exception != null) {
            if ($exception instanceof HttpException) {
                return $this->redirect('/not-found',404);
            }
        }
        return $this->render('error',['exception' => $exception]);
    }
    public function actionNotFound()
    {
        Yii::$app->response->setStatusCode(404);
        return $this->render('404');
    }

}

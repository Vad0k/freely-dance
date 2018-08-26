<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property string $id
 * @property integer $category_id
 * @property string $head_title
 * @property string $head_description
 * @property string $head_keywords
 * @property string $title
 * @property string $image
 * bgSize
 * bgPosition
 * @property string $product_code
 * @property string $description
 * @property string $description_more
 * @property double $price
 * @property string $params
 * @property integer $isFavorite
 * @property integer $isNew
 * @property integer $isVisible
 * @property string $views
 * @property string $similar
 * @property string $time_created
 */
class ModelProducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'head_title', 'head_description', 'head_keywords', 'title', 'image', 'params'], 'required'],
            [['category_id', 'isFavorite', 'isNew', 'isVisible', 'views'], 'integer'],
            [['image', 'description', 'description_more', 'params', 'similar'], 'string'],
            [['price'], 'number'],
            [['time_created'], 'safe'],
            [['head_title', 'product_code'], 'string', 'max' => 100],
            [['bgSize','bgPosition'], 'string', 'max'=> 20],
            [['head_description', 'head_keywords', 'title'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID товара',
            'category_id' => 'ID категории',
            'head_title' => 'Заголовк в поиске',
            'head_description' => 'Описание в поиске',
            'head_keywords' => 'Ключевые слова',
            'title' => 'Название',
            'image' => 'Картинка',
            'product_code' => 'Код продукта',
            'description' => 'Краткое описание',
            'description_more' => 'Полное описание',
            'price' => 'Цена',
            'params' => 'Параметры',
            'isFavorite' => 'Избранный товар?',
            'isNew' => 'Новый товар?',
            'isVisible' => 'Отобразить на сайте',
            'views' => 'Кол-во просмотров',
            'similar' => 'Подробности',
            'time_created' => 'Время создания',
        ];
    }
}

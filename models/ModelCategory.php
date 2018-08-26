<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $label_en
 * @property string $label
 * @property string $type
 * @property string $image
 * @property string $position
 * @property string $bgSize
 * @property string $description
 * @property string $article
 * @property string $head_title
 * @property string $head_description
 * @property string $head_keywords
 * @property string $url
 * @property integer $visible
 * @property integer $sort
 */
class ModelCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'visible', 'sort'], 'integer'],
            [['label', 'article', 'head_title', 'head_description', 'head_keywords'], 'required'],
            [['image', 'article', 'url'], 'string'],
            [['label', 'type', 'head_title'], 'string', 'max' => 100],
            [['position'], 'string', 'max' => 20],
            [['bgSize'], 'string', 'max' => 15],
            [['description'], 'string', 'max' => 300],
            [['head_description', 'head_keywords'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => '№ категории к которой относится данная категория',
            'label' => 'Название категории',
            'type' => 'Тип категории: CATEGORY, PRODUCT, PAGE',
            'image' => 'Изобаржение на категорию',
            'position' => 'Смешение фона, картинки (background-position) Например: 20px -40px, left top, -20px, ...',
            'bgSize' => 'Растяжение иображение по осям (background-size) Например: cover, contain, 100%, 120% 150px, 150% 80%,...',
            'description' => 'Описание категории с (parent_id = 0)',
            'article' => 'Статья внутри категории/подкатегории',
            'head_title' => 'Главный продвигаемый запрос по категориям (не более 70 символов)',
            'head_description' => 'Главное описание для продвижения категории (не более 170 символов)',
            'head_keywords' => 'Ключевые запросы для провижения (через запятую и не более 5-ти)',
            'url' => 'Ссылка на отдедльную статью (если указан "тип категории" как "PAGE")',
            'visible' => 'Опубликовать',
            'sort' => 'Сортировать (порядковый номер)',
        ];
    }
}

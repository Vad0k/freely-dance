<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gallery".
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $alt
 * @property string $description
 * @property integer $visible
 * @property integer $sort
 */
class ModelGallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'image', 'alt', 'description', 'sort'], 'required'],
            [['title', 'image', 'description'], 'string'],
            [['visible', 'sort'], 'integer'],
            [['alt'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'image' => 'Image',
            'alt' => 'Alt',
            'description' => 'Description',
            'visible' => 'Visible',
            'sort' => 'Sort',
        ];
    }
}

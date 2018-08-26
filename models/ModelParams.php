<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "params".
 *
 * @property integer $id
 * @property string $type
 * @property string $title
 * @property string $unit
 * @property string $values
 * @property integer $isAppendPrice
 */
class ModelParams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'params';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'title', 'values'], 'required'],
            [['values'], 'string'],
            [['isAppendPrice'], 'integer'],
            [['type'], 'string', 'max' => 50],
            [['title', 'unit'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'title' => 'Title',
            'unit' => 'Unit',
            'values' => 'Values',
            'isAppendPrice' => 'Is Append Price',
        ];
    }
}

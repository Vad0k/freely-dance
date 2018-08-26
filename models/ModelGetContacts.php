<?php
namespace app\models;
use \yii\base\Model;

class ModelGetContacts extends Model
{
    public $phone;
    public $email;

    public function rules()
    {
        return [
            [['phone'],'required']
        ];

    }
}
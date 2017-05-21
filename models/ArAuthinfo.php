<?php

namespace app\models;

use Yii;
use app\models\Utils;

class ArAuthinfo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'authinfo';
    }

    public function rules()
    {
        return [
            [['datetime', 'user', 'grantor','order'], 'required'],
            [['datetime'], 'safe'],
            [['user', 'grantor'], 'string', 'max' => 32],
            [['order'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datetime' => 'Datetime',
            'user' => 'User',
            'grantor' => 'Grantor',
            'order' => 'Order',
        ];
    }
    public function userTimeline(){
       return Utils::timeline(ArAuthinfo::tableName(),'user');
    }
    public function grantorTimeline(){
       return Utils::timeline(ArAuthinfo::tableName(),'grantor');
    }
    public function userRate(){
       return Utils::rate(ArAuthinfo::tableName(),'user');
    }
    public function grantorRate(){
       return Utils::rate(ArAuthinfo::tableName(),'grantor');
    }

}

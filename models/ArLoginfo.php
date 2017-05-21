<?php

namespace app\models;

use Yii;
use app\models\Utils;


class ArLoginfo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'loginfo';
    }

    public function rules()
    {
        return [
            [['datetime', 'status', 'ip', 'ter', 'name'], 'required'],
            [['datetime'], 'safe'],
            [['last'], 'string', 'max' => 128],
            [['status', 'ter', 'name'], 'string', 'max' => 32],
            [['ip'], 'string', 'max' => 64],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datetime' => 'Datetime',
            'last' => 'Last',
            'status' => 'Status',
            'ip' => 'Ip',
            'ter' => 'Ter',
            'name' => 'Name',
        ];
    }
    public function timeline($range = '')
    {
        return Utils::timeline(ArLoginfo::tableName(),'name');
    }
    public function rate($range ='')
    {
        return Utils::rate(ArLoginfo::tableName(),'name');
    }
}
?>

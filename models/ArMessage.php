<?php

namespace app\models;

use Yii;
use app\models\Utils;

class ArMessage extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'message';
    }

    public function rules()
    {
        return [
            [['datetime', 'creator', 'content', 'type', 'lv'], 'required'],
            [['lv'], 'integer'],
            [['datetime'], 'safe'],
            [['creator'], 'string', 'max' => 32],
            [['content'], 'string', 'max' => 256],
            [['type'], 'string', 'max' => 64],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datetime' => 'Datetime',
            'creator' => 'Creator',
            'content' => 'Content',
            'type' => 'Type',
            'lv' => 'Lv',
        ];
    }
    public function timeline()
    {
        return Utils::timeline(ArMessage::tableName(),'creator');
    }
    public function rate()
    {
        return Utils::rate(ArMessage::tableName(),'creator');
    }
}

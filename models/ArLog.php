<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property integer $user
 * @property string $action
 * @property string $para
 * @property string $datetime
 */
class ArLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user', 'action', 'para', 'datetime'], 'required'],
            [['user'], 'integer'],
            [['datetime'], 'safe'],
            [['action'], 'string', 'max' => 32],
            [['para'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'action' => 'Action',
            'para' => 'Para',
            'datetime' => 'Datetime',
        ];
    }
}

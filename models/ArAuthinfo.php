<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "authinfo".
 *
 * @property integer $id
 * @property string $datetime
 * @property string $user
 * @property string $grantor
 */
class ArAuthinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'authinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime', 'user', 'grantor','order'], 'required'],
            [['datetime'], 'safe'],
            [['user', 'grantor'], 'string', 'max' => 32],
            [['order'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
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
}

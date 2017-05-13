<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "loginfo".
 *
 * @property integer $id
 * @property string $datetime
 * @property string $last
 * @property string $status
 * @property string $ip
 * @property string $ter
 * @property string $name
 */
class ArLoginfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loginfo';
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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
}

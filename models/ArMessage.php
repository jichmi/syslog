<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property string $datetime
 * @property string $creator
 * @property string $content
 * @property string $type
 * @property integer $lv
 */
class ArMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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
}

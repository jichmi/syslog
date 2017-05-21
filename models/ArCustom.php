<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "custom".
 *
 * @property integer $id
 * @property integer $type
 * @property string $datetime
 * @property string $content
 * @property string $receptor
 * @property string $agent
 */
class ArCustom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'datetime', 'content', 'receptor', 'agent'], 'required'],
            [['type'], 'integer'],
            [['datetime'], 'safe'],
            [['content'], 'string', 'max' => 128],
            [['receptor', 'agent'], 'string', 'max' => 64],
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
            'datetime' => 'Datetime',
            'content' => 'Content',
            'receptor' => 'Receptor',
            'agent' => 'Agent',
        ];
    }
}

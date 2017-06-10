<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property integer $type
 * @property integer $owner
 */
class ArSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value', 'type', 'owner'], 'required'],
            [['type', 'owner'], 'integer'],
            [['name', 'value'], 'string', 'max' => 64],
        ];
    }
    public function getUser()
    {
        // 这里uid是auth表关联id, 关联user表的uid id是当前模型的主键id
        return $this->hasOne(ArUser::className(), ['id' => 'owner']);
    }
    public function getStype()
    {
        return AppConst::$_SETTING_TYPE[$this->type];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '设定名称',
            'value' => '设定值',
            'stype' => '设定类型',
            'owner' => '所有者',
        ];
    }
}

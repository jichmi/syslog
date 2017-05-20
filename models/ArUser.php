<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $passwd
 * @property integer $type
 */
class ArUser extends \yii\db\ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }
    private $userType = [
      '001' => 'admin',
      '010' => 'viewer',
      '111' => 'illegal',
    ];

    public function rules()
    {
        return [
            [['name', 'passwd', 'type'], 'required'],
            [['type'], 'string', 'max' => 16],
            [['name', 'passwd'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'passwd' => 'Passwd',
            'type' => 'Type',
        ];
    }

//自动登陆时会调用
    public static function findIdentity($id)
    {
        $temp = parent::find()->where(['id'=>$id])->one();
        return isset($temp)?new static($temp):null;
    }

    public static function findByUsername($username)
    {
        $temp = parent::find()->where(['name'=>$username])->one();
        return isset($temp)?new static($temp):null;
    }
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }
    /**
    * get user type
    */
    public function getType()
    {
        return $this->userType[$this->type];
    }
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->passwd === $password;
    }


}

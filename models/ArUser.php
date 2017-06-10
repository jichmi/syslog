<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

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

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '用户名',
            'passwd' => '密码',
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
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function isAdmin()
    {
        return $this->type == '001';
    }
    public function getType()
    {
        return $this->userType[$this->type];
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }
    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     */
    public function validatePassword($password)
    {
        return $this->passwd === $password;
    }


}

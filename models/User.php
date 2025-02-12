<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['username', 'password_hash', 'email'], 'required'],
            [['username', 'email'], 'unique'],
            ['email', 'email'],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; 
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }


    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null; // Если не используется "auth_key", оставить пустым.
    }

    public function validateAuthKey($authKey)
    {
        return false; // Если не используется "auth_key", оставить пустым.
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->rating = 100; // Начальный рейтинг для новых игроков
            }
            return true;
        }
        return false;
    }

    public function isUser()
    {
        return $this->role === 'user';
    }


   public function isAdmin()
    {
        return $this->role === 'admin' || $this->role === 'superadmin';
    }

    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    public function getGrantedBy()
    {
        return $this->hasOne(User::class, ['id' => 'granted_by']);
    }





}

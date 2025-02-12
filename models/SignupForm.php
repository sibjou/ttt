<?php

namespace app\models;

use yii\base\Model;
use app\models\User;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $captcha;

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required', 'message' => 'Это поле обязательно для заполнения.'],
            ['email', 'email', 'message' => 'Введите корректный email.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Пароль должен содержать минимум 6 символов.'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Этот логин уже занят.'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Этот email уже используется.'],
            ['captcha', 'captcha', 'captchaAction' => 'site/captcha'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password_hash = \Yii::$app->security->generatePasswordHash($this->password);

        return $user->save() ? $user : null;
    }
}



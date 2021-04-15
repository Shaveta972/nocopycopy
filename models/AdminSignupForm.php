<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class AdminSignupForm extends Model
{
    public $email;
    public $username;
    public $first_name;
    public $last_name;
    public $password;
    public $confirmPassword;

    /**
     *
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // email and password are both required
            [
                [
                    'email',
                    'password',
                    'username',
                    'first_name',
                    'last_name',
                    'confirmPassword'
                ],
                'required'
            ],
            [
                [
                    'email'
                ],
                'email'
            ],

            [
                'confirmPassword',
                'compare',
                'compareAttribute' => 'password',
                'message' => \Yii::t('app', 'Passwords don\'t match')
            ]
        ];
    }

    public function loginAdmin()
{
    if ($this->validate() && User::isUserAdmin($this->username)) {
        return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    } else {
        return false;
    }
}
}

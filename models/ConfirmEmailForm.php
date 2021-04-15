<?php
 
namespace app\models;
 
use yii\base\Model;
use yii\base\InvalidParamException;
use Yii;
/**
 * email confirm form
 */
class ConfirmEmailForm extends Model
{
 
    public $email;
 
    /**
     * @var \app\models\User
     */
    private $_user;
 
    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Email token cannot be blank.');
        }
        $this->_user = User::findByEmailConfirmationKey($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong email confirmation token.');
           
        }
 
        parent::__construct($config);
    }
 
    /**
     * Confirms Email.
     *
     * @return bool if password was reset.
     */
    public function confirmEmail()
    {
        $user = $this->_user;
        $user->is_confirmed= User::EMAIL_CONFIRM;
        $user->confirmed_at= new \yii\db\Expression('NOW()');
        $user->removeEmailConfirmationToken();
        return $user->save(false);
    }
 
}
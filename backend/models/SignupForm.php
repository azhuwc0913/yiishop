<?php
namespace backend\models;

use backend\models\Admin;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Signup form
 */
class SignupForm extends ActiveRecord
{
    public $username;
    public $email;
    public $password;
    public $confirm_password;
    public $status;
    public $role;



    public static function tableName()
    {
        return '{{%admin}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\backend\models\Admin', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\backend\models\Admin', 'message' => 'This email address has already been taken.'],

            [['password', 'confirm_password'], 'required'],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>'两次输入的密码不一致'],
            ['password', 'string', 'min' => 6],

            ['status', 'required'],
            ['role', 'safe']
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new Admin();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->status = $this->status;
        $user->role = $this->role;
        $user->setPassword($this->password);
        $user->generateAuthKey();


        if ($user->save()) {
            return $user;
        }else{
            var_dump($user->errors);
        }
    }
}

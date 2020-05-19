<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2019-05-10 23:39
 */
namespace wechat\models\form;

use wechat\models\User;
    /**
     * Login form
     */
class LoginForm extends \yii\base\Model
{
    public $username;
    public $password;
//    public $mobile;

    /** @var User */
    private $_user;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
//          ['mobile','match','pattern'=>'/^1[135789]\d{9}$/'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
//            'mobile' => '手机号',
        ];
    }

    public function validatePassword($attribute)
    {
        if (!$this -> hasErrors()) {
            $this -> _user = $this -> getUser();
            if (!$this -> _user || !$this->_user->validatePassword($this->password) ) {
                return  $this -> addError($attribute , '用户名或密码不正确');
            }
        }
    }
    public function login()
    {
        if ($this->validate()){
            $this->_user -> generateAccessToken();
            if( $this->_user->save(false, ['access_token']) ){
                return $this->_user;
            }else{
                return "false";
            }
        } else {
            return null;
        }
    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }

}
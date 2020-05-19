<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2019-05-11 22:26
 */

namespace wechat\models\form;

use Yii;
use common\models\User;

class SignupForm extends \yii\base\Model
{
    public $username;
    public $password;
    public $repwd;
    public $mobile;
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            [
                'username',
                'unique',
                'targetClass' => User::className(),
                'message' => Yii::t('app', 'This username has already been taken')
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['repwd','compare','compareAttribute'=>'password'],
            ['mobile','match','pattern'=>'/^1[135789]\d{9}$/'],
            ['mobile', 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'repwd' => Yii::t('app','Repwd'),
            'mobile' => Yii::t('app','Mobile'),
        ];
    }

    public function signup()
    {
        if (! $this->validate()) {
            return null;
        }
        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->password = $this->password;
        $user->mobile = $this->mobile;
        $user->generateAuthKey();

        return $user->save(false) ? $user : null;
    }
}
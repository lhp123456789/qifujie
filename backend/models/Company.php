<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-11 09:53
 */

namespace backend\models;

use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class Company extends \common\models\Company
{
    /**
     * @var string
     */
    public $info = '';

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $this->uid = $this->getAttribute("uid");
        $this->info = Company::find()
                    ->select(['u.username','c1.id','c1.uid','c1.company_name','c1.alias','c1.logo','company_url','company_personner','cusc','company_phone','id_number','business_licese','card_picture',
                        'card_pic','company_describe','c1.status','c1.created_at','c1.updated_at'])
                    ->from('{{%company}} c1')
                    ->leftJoin(['{{%user}} u'],'u.id=c1.uid');
        parent::afterFind();
    }
    protected static function _getUsers()
    {
        return \frontend\models\User::find()
            ->select(['id','username'])
            ->orderBy("id asc")->asArray()->all();
    }

    public static function getUsersName(){
        $usernames = self::_getUsers();
//        var_dump($usernames);exit;
        $data = [];
        foreach ($usernames as $k=>$username){
            $data[$username['id']] = $username['username'];
        }

        return $data;
    }

    public function getUser(){
        return $this->hasOne(\frontend\models\User::className(), ['id'=>'uid']);
    }
}
<?php
namespace wechat\models;
/**
 * Created by PhpStorm.
 * User: LHP
 * Date: 2020/5/18
 * Time: 09:46
 */


use yii;
use yii\db\Query;

class UserModel extends \yii\db\ActiveRecord
{
    /*
   * 用户信息
   * $where array
   * @author:lhp
   * @time:2020-5-18
   * */
    public function getUserDetail($where=[]){
        $query=new Query();
        $query->select(['id','username','mobile','email','openid'])
            ->from('qd_user')
            ->where(['status'=>10]);
        if($where){
            $query->andWhere($where);
        }
        $user_data=$query->one();

        return $user_data;
    }
    /*添加用户
   *$param array
   *@time:2020-5-18
   *@author:Lhp
   */
    public function addUser($param=[]){
        $connection=Yii::$app->db;
        $transaction=$connection->beginTransaction();
        try{
            $param['created_at']=time();
            $param['updated_at']=time();
            $connection->createCommand()->insert('qd_wechat_user',$param)->execute();
            $transaction->commit();
            return true;
        }catch (\Exception $e){
            $transaction->rollBack();
            return false;
        }
    }
}
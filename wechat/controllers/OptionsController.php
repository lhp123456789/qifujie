<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-08-30 18:10
 */
namespace wechat\controllers;

use wechat\models\Options;
use yii\web\Response;

class OptionsController extends PublicController
{
    public $modelClass = "wechat\models\Options";


    public function actionIndex(){
    //logo,标题,关键字,备案号
        $record = Options::find() -> select(['id','name','value'])
            ->where(['id' =>[1,2,3,28,7]])
            ->asArray()
            ->all();
        return $this->_response($record,200);
    }
}

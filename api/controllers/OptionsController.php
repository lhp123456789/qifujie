<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-08-30 18:10
 */
namespace api\controllers;

use api\models\Options;
use yii\web\Response;

class OptionsController extends PublicController
{
    public $modelClass = "api\models\Options";

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        //默认浏览器打开返回json
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actions()
    {
        return [];
    }
    public function verbs()
    {
        return [
            'index' => ['GET'],
        ];
    }

    public function actionIndex(){
    //logo,标题,关键字,备案号
        $record = Options::find() -> select(['id','name','value'])
            ->where(['id' =>[1,2,3,28,7]])
            ->asArray()
            ->all();
        $data=[
            'data'=>  $record,
            'code'=>200,
            'msg'=>'成功'
        ];
        return $data;
    }


}

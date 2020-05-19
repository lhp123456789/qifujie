<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-08-30 18:10
 */
namespace api\controllers;

use api\models\Category;
use yii\web\Response;

class NavigationbarController extends PublicController
{
    public $modelClass = "api\models\Navigationbar";

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
        //        导航栏
        $bar = Category::find()->select(['id','name barname','image','location'])
            ->where(['status' => 1])
            ->andWhere(['parent_id'=>0])
            ->orWhere(['location'=>1])
            ->orderBy('sort desc')
            ->asArray()
            ->all();

        //底部菜单
        $bottom = Category::find()->select(['id','name barname','image','location'])
        ->where(['status' => 1])
        ->andWhere(['location'=>2])
        ->asArray()
        ->all();


        $data=[
            'data'=>  [$bar,$bottom],
            'code'=>200,
            'msg'=>'成功'
        ];
        return $data;

    }


}

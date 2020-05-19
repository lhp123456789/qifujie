<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-08-30 18:10
 */
namespace wechat\controllers;

use wechat\models\Category;
use yii\web\Response;

class NavigationbarController extends PublicController
{
    public $modelClass = "wechat\models\Navigationbar";


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
        $this->_response([$bar,$bottom], 200);
    }
}

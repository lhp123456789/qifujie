<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-08-30 18:10
 */
namespace api\controllers;

use api\models\CompanyModel;
use Yii;

class CategoryController extends PublicController
{
    public $modelClass = "api\models\Company";
public function actionHotservice(){

    $company = new CompanyModel();
    $lists = $company->CompanyHot();

//var_dump($lists);exit();
    $data=[
        'data' =>  $lists,
        'code' => 200,
        'msg' => '成功'
    ];
    return $data;
}



 
}

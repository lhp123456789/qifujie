<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-08-30 18:10
 */
namespace api\controllers;


use api\models\CitiesModel;
use api\models\PublicModel;
use Yii;
class CitiesController extends PublicController
{
    public $modelClass = "api/models/territory";
    //热门城市接口
    public function actionHotcity(){
        $type=new CitiesModel();
        $data = $type->getHotCity();
        $data = [
            'data' => $data,
            'code'=>200,
            'msg'=>'成功'
        ];
        return $data;
    }
    //城市列表接口
    public function actionCitylist(){
        $type=new CitiesModel();
        $data=$type->getCityList();
        $data = [
            'data' => $data,
            'code'=>200,
            'msg'=>'成功'
        ];
        return $data;
    }

    //搜索接口
    public function actionCitysearch(){
        $look = new CitiesModel();
        $json = $this->behaviors();
        $keywords =$this->verifyEmpty($json,'keywords');//搜索关键字;
        $params['keywords'] = $keywords;
        $data = $look->getCitySearch($params);
        $data = [
            'data' => $data,
            'code'=>200,
            'msg'=>'成功'
        ];
        return $data;
    }

}

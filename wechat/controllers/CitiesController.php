<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-08-30 18:10
 */
namespace wechat\controllers;


use wechat\models\CitiesModel;
use wechat\models\PublicModel;
use Yii;
class CitiesController extends PublicController
{
    public $modelClass = "wechat/models/territory";
    //热门城市接口
    public function actionHotcity(){
        $type=new CitiesModel();
        $data = $type->getHotCity();
        $this->_response($data, 200);
    }
    //城市列表接口
    public function actionCitylist(){
        $type=new CitiesModel();
        $data=$type->getCityList();
        $this->_response($data, 200);
    }

    //搜索接口
    public function actionCitysearch(){
        $look = new CitiesModel();
        $json = $this->behaviors();
        $keywords =$this->verifyEmpty($json,'keywords');//搜索关键字;
        $params['keywords'] = $keywords;
        $data = $look->getCitySearch($params);
        $this->_response($data, 200);
    }

}

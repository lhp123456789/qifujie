<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-08-30 18:10
 */
namespace wechat\controllers;

use wechat\models\CompanyModel;
use wechat\models\Category;
use yii\web\Response;
use Yii;



class CategoryController extends PublicController
{
    public $modelClass = "wechat\models\Category";

    

	public function actionHotservice(){
	
	    $company = new CompanyModel();
	    $lists = $company->CompanyHot();

	    $this->_response([], 200);
	    
	}

//模糊查询
    public function actionCompanyfuzzy(){

        if(Yii::$app->request->isPost){
            $request = \Yii::$app->request;
            $cid =$request->post('cid');
            $p_cid =$request->post('p_cid');
            $keywords =$request->post('keywords');
            $pagination =$request->post('pagination');
            $params['page'] = $pagination['page'];
            $params['psize'] = $pagination['psize'];
            $params['keywords'] = $keywords;
            $params['cid'] = $cid;
            $params['p_cid'] = $p_cid;
            $look = new CompanyModel();
            $data = $look->CompanyFuzzySearch($params);
            $this->_response($data, 200);
        }else{
	    	$this->_response([], -1);
        }
    }
}

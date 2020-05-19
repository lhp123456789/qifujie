<?php

namespace wechat\controllers;

use wechat\models\CompanyModel;
use wechat\models\PublishModel;
use Yii;
class CompanyController extends PublicController
{
    public $modelClass = "wechat\models\Company";
    //业务分类列表
    public function actionTypelist(){
        $type=new CompanyModel();
        $data=$type->getTypeList();
        $this->_response($data, 200);
    }
    public function actionInfo(){
        if($this->is_post()){
            $detail = new CompanyModel();
            $request = Yii::$app->request;
            $id = $request->post('id');
            if($id){
                $msg = $detail->GetUserDetail(['c2.id'=>$id]);
                $company=new CompanyModel();
                $company_detail=$company->CompanyDetail(['c1.uid'=>$id]);
                if($company_detail){
                    $msg['is_company_detail']=1;//有企业信息
                    $this->_response($msg, 200);
                }else{
                    $msg['is_company_detail']=0;//没有企业信息
                    $this->_response($msg, 10008);
                }
            }else{
                $this->_response([], 10001);
            }
        }
    }
     //上传图片
    public function actionUpload(){

         $info = $_FILES['file'];
        $res = new CompanyModel();
        $data = $res->reveive($info);
        $this->_response($data, 200);
    	 
    }

    //公司业务搜索
    public function actionCompanysearch(){

        if(Yii::$app->request->isPost){
    		$request = \Yii::$app->request;
        	$cid =$request->post('cid');
        	$keywords =$request->post('keywords');
        	$pagination =$request->post('pagination');
        	$params['page'] = $pagination['page'];
        	$params['psize'] = $pagination['psize'];
        	$params['keywords'] = $keywords;
        	$params['cid'] = $cid;
			$params['p_cid'] =$request->post('p_cid');
        	$look = new CompanyModel();
        	$data = $look->CompanyTypeSearch($params);
            $this->_response($data, 200);
    	}else
    	{
            $this->_response([], -1);
    	}
    }

      /*
     * 企业入驻/修改
     * @time:2020-5-7
     * @author:Lhp
    */
      public function actionCompanyenter(){
        $enter = new CompanyModel();
        $request = Yii::$app->request;
        if($request->isPost){
            $data['uid'] = $request->post('uid');//用户id
            $id =$request->post('id');
            $data['company_name'] = $request->post('company_name');//企业全称
            $data['company_alias'] = $request->post('company_alias');//企业简称
            $data['logo'] = $request->post('logo');//企业logo
            $data['company_url'] = $request->post('company_url');//公司url
            $data['company_personner'] = $request->post('company_personner');//公司注册人姓名
            $data['company_phone'] =$request->post('company_phone');//注册人手机号
            $data['cusc'] = $request->post('cusc');//社会统一信用代码
            $data['business_licese'] = $request->post('business_licese');//公司营业执照
            $data['card_picture'] =$request->post('card_picture');//身份证正面
            $data['card_pic'] = $request->post('card_pic');//身份证反面
            $data['company_describe'] = $request->post('company_describe');//企业描述
            $data['id_number'] =$request->post('id_number');//法人身份证号
            if(empty($data['uid'])||empty($data['company_name'])||empty($data['company_alias']))
            {
                $this->_response($data, 10001);
            }
            $result = $enter->CompanyEnter($data,['id'=>$id]);
            $this->_response(['company_id'=>$result], 200);
        }else{
            $this->_response([], -1);
        }
    }

    //公司详情
    public function actionCompanydetail(){
        if($this->is_post()){
            $detail = new CompanyModel();
            $request = Yii::$app->request;
            $id =$request->post('id');
            if($id){
                $data = $detail->CompanyDetail(['c1.id'=>$id]);
                $this->_response($data, 200);
            }else{
                $this->_response([], 100);
            }
        }
    }
    
    /*
	* 删除企业网站url
	* @time:2020-05-07
	* @author:Lhp
	*/
    public function actionCompanyurl(){
        if($this->is_post()){
            $request = Yii::$app->request;
            $Publishmodel= new PublishModel();
            $CompanyModel= new CompanyModel();
            $id =$request->post('id');//企业id
            $url =$request->post('url');//网站url
            //查询企业详情
            $company_detail=$CompanyModel->CompanyDetail(['c1.id'=>$id]);
              if(empty($company_detail['company_url'])){
                  $this->_response([], 10007);
            }
            $arr=explode(';',$company_detail['company_url']);
            $is_exits = array_diff($arr, [$url]);
            $url_new=implode ($is_exits,';');
            //更新企业网站url
            $company_url=$Publishmodel->updateCompany(['company_url'=>$url_new],['id'=>$id]);
            $publish_all=$Publishmodel->getPublishAll(['comp_id'=>$id]);
            foreach($publish_all as $k=>$v){
                if($v['web_url']==$url){
                    $datas= $Publishmodel->addCompanyPublish(['web_url'=>''],['id'=>$v['id']]);
                }
            }
            if($company_url){
                $this->_response([], 200);
            }else{
                $this->_response([], 200);
            }
        }else{
            $this->_response([], -1);
        }
    }
}

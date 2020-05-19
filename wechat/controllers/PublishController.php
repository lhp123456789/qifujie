<?php
/**
 * Created by PhpStorm.
 * User: LHP
 * Date: 2020/4/29
 * Time: 14:54
 */

namespace wechat\controllers;
use wechat\models\PublishModel;
use yii;

class PublishController extends PublicController
{
    public $modelClass = "wechat\models\Publish";
    /*
     * 企业详情
     * @time:2020-4-29
     * @author:Lhp
    */
    public function actionIndex(){
        $request = Yii::$app->request;
        $comp_id =$request->get('comp_id',1);
        $PublishModel = new PublishModel();
        $datas= $PublishModel->getCompanyStatus(['c1.id'=>$comp_id]);
        $this->_response($datas,200);
    }
    /*
     * 企业发布
     * @time:2020-4-29
     * @author:Lhp
    */
    public function actionCompanypublishadd(){
        if($this->is_post()){
            $request = Yii::$app->request;
            $Publishmodel= new PublishModel();
            $id =$request->post('id');//发布id
            $data['cid'] =$request->post('cid');//二级类别id
             $data['p_cid'] =$request->post('p_cid');//一级类别id
            $data['comp_id'] =$request->post('comp_id');//企业id
            $data['web_url'] =$request->post('web_url');//官网地址
            $data['short_name'] =$request->post('short_name');//类别简称
            if(empty($data['p_cid'])||empty($data['cid'])||empty($data['comp_id'])||empty($data['web_url']))
            {
                $this->_response([],10001);
            }
            if(empty($id)){
                $data['unique'] =$this->nonceStr();//唯一编码
            }
            $companydetail=$Publishmodel->getCompanyStatus(['id'=> $data['comp_id']]);
            
            if(!empty($companydetail['company_url'])){
                $is_exist=stripos($companydetail['company_url'],$data['web_url']);
                if($is_exist===false){
                    $url=$companydetail['company_url'].';'.$data['web_url'];
                }else{
                	$url='';
                }
            }else{
                $url=$data['web_url'];
            }
            
            if(!empty($url)){
            	 $Publishmodel->updateCompany(['company_url'=>$url],['id'=>$data['comp_id']]);
            }
	
            $datas= $Publishmodel->addCompanyPublish($data,['id'=>$id]);
             if($datas){
                  $this->_response($datas,200);
            }else{
                  $this->_response([],100);
            }
        }else{
             $this->_response([],-1);
        }
    }
    /*
     * 我的发布
     * @time:2020-4-29
     * @author:Lhp
    */
    public function actionCompanypublish(){
        if(Yii::$app->request->isPost){
            $request = Yii::$app->request;
            $keywords =$request->post('keywords');
            $pagination =$request->post('pagination');
            $params['cid'] =$request->post('cid');//二级类别id
            $params['p_cid'] =$request->post('p_cid');//一级类别id
            $params['uid'] =$request->post('uid');//用户id
            $params['comp_id'] =$request->post('comp_id');//企业id
            $params['status'] =$request->post('status');//状态
            $params['page'] = $pagination['page'];
            $params['psize'] = $pagination['psize'];
            $params['keywords'] = $keywords;
			if(empty($params['uid'])||empty($params['comp_id'])||empty($params['status']))
			{
                 $this->_response([],10001);
            }
            $PublishModel = new PublishModel();
            $data = $PublishModel->CompanyPublishSearch($params);
             $this->_response($data,200);
        }else{
             $this->_response([],100);
        }
    }
    /**
     * @Notes:企业发布删除
     * @User:Lhp
     * @Time: 2020/4/29
     */
    public function actionCompanypublishdelete()
    {
        if ($this->is_post()) {
            $PublishModel = new PublishModel();
            $request = Yii::$app->request;
            $id =$request->post('id');
            if ($id) {
                $row = $PublishModel->CompanyPublishDelete(["in","id",$id]);
                 if ($row) {
                      $this->_response([],200);
                }else{
                      $this->_response([],200);
                }
            }
        }
    }
    
       /*
    * 企业点击量
    * @time:2020-05-06
    * @author:Lhp
   */
    public function actionCompanypublishclick(){
        if($this->is_post()){
            $request = Yii::$app->request;
            $Publishmodel= new PublishModel();
            $id =$request->post('id',1);//发布id
            $detail= $Publishmodel->getPublish(['id'=>$id]);
            $datas= $Publishmodel->addCompanyPublish(['click'=>$detail['click']+1],['id'=>$id,'tag'=>'click']);
             $this->_response($datas,200);
        }else{
             $this->_response([],-1);
        }
    }
}
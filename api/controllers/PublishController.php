<?php
/**
 * Created by PhpStorm.
 * User: LHP
 * Date: 2020/4/29
 * Time: 14:54
 */

namespace api\controllers;
use api\models\PublishModel;
use yii;

class PublishController extends PublicController
{
    public $modelClass = "api\models\Publish";
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
        $result = [
            'data' => $datas,
            'code' => 200,
            'msg' => '成功'
        ];

        return $result;
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
              if(empty($data['p_cid'])||empty($data['cid'])||empty($data['comp_id'])||empty($data['web_url'])){
                $data = [
                    'data' => [],
                    'code'=>-1,
                    'msg'=>'缺少必要参数！'
                ];
                return $data;
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
                $result = [
                    'data' => $datas,
                    'code' => 200,
                    'msg' => '成功'
                ];
            }else{
                $result = [
                    'data' => [],
                    'code' => 100,
                    'msg' => '失败'
                ];
            }
            return $result;
        }else{
            $result = [
                'data' => [],
                'code' => -1,
                'msg' => '请求异常'
            ];
            return $result;
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
			if(empty($params['uid'])||empty($params['comp_id'])||empty($params['status'])){
                $data = [
                    'data' => [],
                    'code'=>-1,
                    'msg'=>'缺少必要参数！'
                ];
                return $data;
            }
            $PublishModel = new PublishModel();
            $data = $PublishModel->CompanyPublishSearch($params);
            $data = [
                'data' => $data,
                'code'=>200,
                'msg'=>'成功'
            ];
            return $data;
        }else{
            $data = [
                'data' => [],
                'code'=>-1,
                'msg'=>'请求异常！'
            ];
            return $data;
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
                    $data = [
                        'data' => [],
                        'code'=>200,
                        'msg'=>'删除成功！'
                    ];
                }else{
                    $data = [
                        'data' => [],
                        'code'=>100,
                        'msg'=>'删除失败！'
                    ];
                }
                
                return $data;
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
            $result = [
                'data' => $datas,
                'code' => 200,
                'msg' => '成功'
            ];
            return $result;
        }else{
            $result = [
                'data' => [],
                'code' => -1,
                'msg' => '请求异常'
            ];
            return $result;
        }
    }
}
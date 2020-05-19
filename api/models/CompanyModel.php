<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-08-30 18:10
 */
namespace api\models;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class CompanyModel extends PublicModel
{
	public function reveive($info){
        if ((($info["type"] == "image/jpg") || ($info["type"] == "image/jpeg")|| ($info["type"] == "image/png")))
        {

            $save ='../../web/uploads/images/'.date('Ymd');
            $tmp = $info["tmp_name"];
            if( !file_exists($save) ){
                mkdir($save, 0777,true);
            }
            $suffix = $info["name"];//原文件名
            $file = "";
            $fileType = "";
//            $fileType = strrchr($value1, '.');
            $file = '/'.date('Ymd').uniqid().$suffix;//新
            move_uploaded_file($tmp,$save.$file);
            /*https://api.qifujie.cn*/
            return ['src'=>'https://api.qifujie.cn/uploads/images/'.date('Ymd').$file];
        } else {
            return  "上传内容不规范";
        }

    }
    
     
   
    
    //业务种类列表
    public function getTypeList(){
        $query=new Query();
        $data=$query->select(['id','parent_id','name'])
            ->from(['c1'=>$this->CATEGORY_TABLE])
            ->orderby('c1.id asc')
            ->all();
        $arr_data= $this->recursion($data,0);
//        print_r($arr_data);exit;
        return $arr_data;
    }

    //企业详情
    public function CompanyDetail($where=[]){
        $query = new Query();
        $query->select(['c1.id company_id','c2.name','company_name','company_alias','logo','company_url','business_licese','company_personner','company_phone','cusc','id_number','company_product','company_describe','c1.uid','c1.id company_id','id_number','card_picture','card_pic','c1.status company_status','c3.short_name'])
            ->from(['c1'=>$this->COMPANY_TABLE])
            ->leftJoin(['c3'=>$this->COMP_ADD_TABLE],'c3.comp_id=c1.id')
            ->leftJoin(['c2'=>$this->CATEGORY_TABLE],'c2.id=c3.cid');
        if($where){
            $query->andWhere($where);
        }
        $result = $query->one();

        return $result;
    }
    //公司业务搜索
    public function CompanyTypeSearch($params=[]){
        $query = new Query();
        //页码

        if(!empty($params['page'])){
            $this->defaultPage = $params['page'];
        }
        //页大小
        if(!empty($params['psize'])){
            $this->defaultPageSize = $params['psize'];
        }
        //排序
        $params['order_by'] = 'c1.created_at asc';
        //序号
        $offset = ($this->defaultPage - 1) * $this->defaultPageSize;


        $query->select(['c3.id','c2.name','company_name','company_alias','logo','web_url','company_personner',
                                'company_phone','company_product','company_describe','c22.name p_type_name','c22.id p_cid','c3.short_name'])
            ->from(['c1'=>$this->COMPANY_TABLE])
            ->leftJoin(['c3'=>$this->COMP_ADD_TABLE],'c3.comp_id=c1.id')
            ->leftJoin(['c2'=>$this->CATEGORY_TABLE],'c2.id=c3.cid')
            ->leftJoin(['c22'=>$this->CATEGORY_TABLE],'c22.id=c3.p_cid')
            ->where(['c3.status'=>1]);
        //传入参数进行搜索
        if (!empty($params['cid'])){
            $query->andWhere(['c3.cid'=>$params['cid']]);
        }
        
          if (!empty($params['p_cid'])){
            $query->andWhere(['c3.p_cid'=>$params['p_cid']]);
        }
        //模糊查询
         if (!empty($params['keywords'])) {
            $query->andWhere(['or', ['like', 'c2.name', $params['keywords']],
               ['like', 'c22.name', $params['keywords']]
            ]);
        }
        $All = clone $query;
        $result = $query
            ->offset($offset)
            ->limit($this->defaultPageSize)
            ->orderBy($params['order_by'])
            ->all();

        $count = $All -> count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => $this->defaultPageSize]);
        $page_count = $pages->getPageCount();
        $page_size = $pages->getPageSize();
        $pagination = ['page' => $this->defaultPage, 'page_count' => $page_count, 'psize' => $page_size, 'count' => $count];

        return ['data' => $result, 'pagination' => $pagination];

    }

     /*
     * 企业入驻/修改
     *$params array
     *$where array
     * @time:2020-5-7
     * @author:Lhp
    */
       public function CompanyEnter($params=[],$where=[]){
        $connection=\Yii::$app->db;
        $transaction=$connection->beginTransaction();
        try{
            if (empty($where['id'])) {
                $params['created_at']=time();
                $params['updated_at']=time();
                $connection->createCommand()->insert($this->COMPANY_TABLE,$params)->execute();
                $last_id=$connection->getLastInsertID();
            } else {
                $params['updated_at']=time();
                $params['status']=2;
                $connection->createCommand()->update($this->COMPANY_TABLE, $params, ['id'=>$where['id']])->execute();
                $last_id=$where['id'];
            }
            $transaction->commit();
            return $last_id;
        }catch (\Exception $e){
            $transaction->rollBack();
            return false;
        }
    }
     /*
    * 获取用户详情
    * */
    public function GetUserDetail($where=[]){
        $query = new Query();
        $query->select(['c2.id userid','username','company_alias','company_name','cusc','company_phone','web_url','business_licese','c1.id company_id','c1.status company_status','access_token'])
            ->from(['c1'=>$this->COMPANY_TABLE])
            ->leftJoin(['c2'=>$this->USER_TABLE],'c2.id=c1.uid')
            ->leftJoin(['c3'=>$this->COMP_ADD_TABLE],'c3.comp_id=c1.id');
        if($where){
            $query->andWhere($where);
        }
        $result = $query->one();

        return $result;
    }

}
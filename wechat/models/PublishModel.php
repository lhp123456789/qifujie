<?php
/**
 * Created by PhpStorm.
 * User: LHP
 * Date: 2020/4/29
 * Time: 15:03
 */

namespace wechat\models;
use yii;
use yii\db\Query;
use yii\data\Pagination;
class PublishModel extends PublicModel
{
    /*企业状态
      *$param array
      *@time:2020-4-29
      *@author:Lhp
      */
    public function getCompanyStatus($where=[]){
        $query=new Query();
        $data =$query->select(['c1.id','c1.status','c1.company_url'])
            ->from(['c1'=>$this->COMPANY_TABLE])
            ->where($where)
            ->one();

        return $data;
    }
       /*企业发布/编辑
       *$param array
       *$where array
       *@time:2020-4-29
       *@author:Lhp
       */
    public function addCompanyPublish($param=[],$where=[]){
        $connection=Yii::$app->db;
        $transaction=$connection->beginTransaction();
        try{
            if (empty($where['id'])) {
                $param['created_at']=time();
                $param['updated_at']=time();
                $connection->createCommand()->insert($this->COMP_ADD_TABLE,$param)->execute();
            } else {
            	if(!isset($where['tag'])){
                    $param['status']=2;
                }
                $param['updated_at']=time();
          
                $connection->createCommand()->update($this->COMP_ADD_TABLE, $param, ['id'=>$where['id']])->execute();
            }
            $transaction->commit();
            return true;
        }catch (\Exception $e){
            $transaction->rollBack();
            return false;
        }
    }
    /*企业我的发布
      *$param array
      *@time:2020-4-29
      *@author:Lhp
      */
    public function CompanyPublishSearch($params=[]){
        $query = new Query();
        if(!empty($params['page'])){
            $this->defaultPage = $params['page'];
        }
        if(!empty($params['psize'])){
            $this->defaultPageSize = $params['psize'];
        }
        $params['order_by'] = 'c3.updated_at desc';
        $offset = ($this->defaultPage - 1) * $this->defaultPageSize;
        $query->select(['c3.id','company_name','company_alias','logo','web_url','company_personner','company_phone','company_product','company_describe','c3.click','c3.unique','c3.status','from_unixtime(c3.created_at,\'%Y-%m-%d %H:%i\')created_at','from_unixtime(c3.updated_at,\'%Y-%m-%d %H:%i\')updated_at','c2.name type_name','c3.error_result','c22.name p_type_name','c3.short_name'])
            ->from(['c1'=>$this->COMPANY_TABLE])
            ->leftJoin(['c3'=>$this->COMP_ADD_TABLE],'c3.comp_id=c1.id')
            ->leftJoin(['c2'=>$this->CATEGORY_TABLE],'c2.id=c3.cid')
            ->leftJoin(['c22'=>$this->CATEGORY_TABLE],'c22.id=c3.p_cid')
            ->where(['c1.status'=>1]) ;
		if (!empty($params['p_cid'])){
            $query->andWhere(['c3.p_cid'=>$params['p_cid']]);
        }
        if (!empty($params['status'])){
            $query->andWhere(['c3.status'=>$params['status']]);
        }
        if (!empty($params['cid'])){
            $query->andWhere(['c3.cid'=>$params['cid']]);
        }
        if (!empty($params['comp_id'])){
            $query->andWhere(['c3.comp_id'=>$params['comp_id']]);
        }
        if (!empty($params['uid'])){
            $query->andWhere(['c1.uid'=>$params['uid']]);
        }
        if (!empty($params['keywords'])) {
            $query->andWhere(['or',
                ['like', 'company_name', $params['keywords']],
                ['like', 'company_alias', $params['keywords']],
                ['like', 'c3.unique', $params['keywords']],
                ['like', 'c3.short_name', $params['keywords']],
            ]);
        }
        $All = clone $query;
        $result = $query
            ->offset($offset)
            ->limit($this->defaultPageSize)
            ->orderBy($params['order_by'])
            ->all();

        $count = $All -> count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' =>$this->defaultPageSize]);
        $page_count = $pages->getPageCount();
        $page_size = $pages->getPageSize();
        $pagination = ['page' => $this->defaultPage, 'page_count' => $page_count, 'psize' => $page_size, 'count' => $count];
        return ['data' => $result, 'pagination' => $pagination];
    }

    /**
     * @Notes:删除发布信息
     * @param array $where
     * @return bool
     * @User:Lhp
     * @Time: 2020/4/29
     */
    public function CompanyPublishDelete($where = [])
    {
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $connection->createCommand()->delete($this->COMP_ADD_TABLE, $where)->execute();
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
    
       /*企业编辑
     *$param array
     *$where array
     *@time:2020-4-30
     *@author:Lhp
     */
    public function updateCompany($param=[],$where=[]){
        $connection=Yii::$app->db;
        $transaction=$connection->beginTransaction();
        try{
            if (empty($where['id'])) {
                $param['created_at']=time();
                $param['updated_at']=time();
                $connection->createCommand()->insert($this->COMPANY_TABLE,$param)->execute();
            } else {
                $param['updated_at']=time();
                $connection->createCommand()->update($this->COMPANY_TABLE, $param, ['id'=>$where['id']])->execute();
            }
            $transaction->commit();
            return true;
        }catch (\Exception $e){
            $transaction->rollBack();
            return false;
        }
    }
     /*企业单条分类信息
     *$param array
     *$where array
     *@time:2020-5-6
     *@author:Lhp
     */
      public function getPublish($where=[]){
        $query=new Query();
            $data =$query->select(['id','cid','p_cid','comp_id','unique','web_url','click','status','error_result'])
            ->from(['c1'=>$this->COMP_ADD_TABLE])
            ->where($where)
            ->one();

        return $data;
    }
    /*企业多条分类信息
     *$param array
     *$where array
     *@time:2020-5-7
     *@author:Lhp
     */
     public function getPublishAll($where=[]){
        $query=new Query();
        $data =$query->select(['id','cid','p_cid','comp_id','unique','web_url','click','status','error_result'])
            ->from(['c1'=>$this->COMP_ADD_TABLE])
            ->where($where)
            ->all();
        return $data;
    }
}
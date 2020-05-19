<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-08-30 18:10
 */
namespace api\models;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class CitiesModel extends PublicModel
{
    //热门城市
    public function getHotCity(){
        $query=new Query();

        //热门城市
        $data1 = $query->select(['map_name'])
            ->from(['t1' => $this->TERRITORY_TABLE])
            ->where(['status'=>1])
            ->andWhere(['hot'=> 1])
            ->all();

        return ['data1'=>$data1];
    }
    //城市列表
    public function getCityList(){
        $query=new Query();


        //城市列表
        $arr_data = $query->select(['id','parent_id','map_name'])
            ->from(['c1'=>$this->TERRITORY_TABLE])
            ->orderby('sort asc')
            ->andWhere(['<>','sort',0])
            ->all();
       $data2 = $this->recursion($arr_data,0);
//     print_r($data2);exit;

        return ['data2'=>$data2];

    }


    //城市搜索
    public function getCitySearch($params = []){
        $query = new Query();
        $params['order_by'] = 'sort asc';
        $query->select([''])
              ->from('')
              ->leftJoin('')
              ->where('');
        //按城市名称进行查找
        if (!empty($params['keywords'])) {
            $query->andWhere( ['like', 'map_name', $params['keywords']
                  ]);
            }
    }
}
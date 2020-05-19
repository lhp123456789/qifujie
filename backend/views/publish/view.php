<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2018-02-24 22:14
 */

use common\libs\Constants;
use yii\widgets\DetailView;

/** @var $model common\models\Category */
?>
<?=DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute'=>'id'
        ],
        [
            'attribute'=>'comp_id',
            'label' => "公司全称",
            'value' => function($model){
                if( $model->comp_id === null ){
                    return "";
                }
//                var_dump($model);exit();
              return $model->comp->company_alias;
            }
        ],
        [
            'attribute'=>'comp_id',
            'label' => "公司简称",
            'value' => function($model){
                return $model->comp->company_name;
            }
        ],
        [
            'attribute' => 'p_cid',
            'label' =>  '一级类别',
            'value' => function($model){
                return $model->pcate->name;
            }
        ],
        [
            'attribute' => 'cid',
            'label' => '二级类别',
            'value' => function($model){
                return $model->cate->name;
            }
        ],
        [
            'attribute' => 'logo',
            'format' => 'raw',
            'value' => function($model){
                $logo = call_user_func(function()use($model){
                    if (strpos($model->comp->logo, "/") === 0){
                        return substr($model->comp->logo, 1);
                    }
                    return $model->comp->logo;
                });
                return "<img style='max-width:200px;max-height:200px' src='" . $logo . "' >";
            }
        ],

        [
            'attribute'=>'company_phone',
            'label' => "公司电话",
            'value' => function($model){
                return $model->comp->company_phone;
            }

        ],
        [
            'attribute'=>'company_product',
            'label' => "公司产品",
            'value' => function($model){
                return $model->comp->company_product;
            }
        ],
        [
            'attribute'=>'company_describe',
            'label' => "公司简介",
            'value' => function($model){
                return $model->comp->company_describe;
            }
        ],
        [
            'attribute'=>'click',
            'label' => "点击量",
            'value' => function($model){
                return $model->web_url;
            }
        ],
        'unique',
        [
            'attribute'=>'unique',
            'label' => "唯一编号",
            'value' => function($model){
//    print_r($model->unique);exit();
                return $model->unique;
            }
        ],
        [
            'attribute'=>'error_result',
            'label' => "失败原因",
            'value' => function($model){
                return $model->error_result;
            }
        ],
        [
            'attribute' => 'status',
            'value' => function($model){
                if( $model['status'] === null ){
                    $model['status'] = Constants::COMPANY_ADD_YES;
                }
                return Constants::getADDStatusItems($model->status);
            }
        ],
        'created_at:datetime',
        'updated_at:datetime',
    ]
])?>

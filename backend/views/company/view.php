<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-14 12:09
 */

use common\libs\Constants;
use yii\widgets\DetailView;

/**
 * @var $model backend\models\Company
 */
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'attribute' => 'uid',
            'label' => "用户名",
            'value' => function($model){
                if( $model->uid === null ){
                    return "";
                }
//    echo "<pre>";print_r($model);exit;
                return $model->user->username;
            }
        ],
        [
            'attribute' => 'company_name',
            'value' => function($model){
                return $model->company_name;
            }
        ],
        'company_alias',
        [
            'attribute' => 'logo',
            'format' => 'raw',
            'value' => function($model){
                $logo = call_user_func(function()use($model){
                    if (strpos($model->logo, "/") === 0){
                        return substr($model->logo, 1);
                    }
                    return $model->logo;
                });
                return "<img style='max-width:200px;max-height:200px' src='" . $logo . "' >";
            }
        ],
        'company_url',
        'company_personner',
        'company_phone',
        'cusc',
        'id_number',

        [
            'attribute' => 'business_licese',
            'format' => 'raw',
            'value' => function($model){
                return "<img style='max-width:200px;max-height:200px' src='" . $model->business_licese . "' >";
            }
        ],
        [
            'attribute' =>   'card_picture',
            'format' => 'raw',
            'value' => function($model){
                return "<img style='max-width:200px;max-height:200px' src='" . $model->card_picture . "' >";
            }
        ],
        [
            'attribute' => 'card_pic',
            'format' => 'raw',
            'value' => function($model){
                return "<img style='max-width:200px;max-height:200px' src='" . $model->card_pic . "' >";
            }
        ],

        'company_product',
        'company_describe',
        [
            'attribute' => 'status',
            'value' => function($model){
                return Constants::getStatusItems($model->status);
            }
        ],
        'created_at:datetime',
        'updated_at:datetime',

    ],
]) ?>
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
        'id',
        [
            'label' => Yii::t('app', 'Parent Category Name'),
            'attribute' => 'parent_id',
            'value' => function($model){
                return $model->parent === null ? '顶级类别' : $model->parent->name;
            }
        ],
        [
            'attribute' => 'image',
            'format' => 'raw',
            'value' => function($model){
                $image = call_user_func(function()use($model){
                    if (strpos($model->image, "/") === 0){
                        return substr($model->image, 1);
                    }
                    return $model->image;
                });
                return "<img style='max-width:200px;max-height:200px' src='" . $image . "' >";
            }
        ],
        'name',
        'alias',
        'sort',
        [
            'attribute' => 'status',
            'value' => function($model){
                return Constants::getStatus($model->status);
            }
        ],
        'created_at:datetime',
        'updated_at:datetime',
    ],
])?>

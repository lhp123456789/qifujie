<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2018-02-24 21:04
 */

use common\libs\Constants;
use yii\widgets\DetailView;

/**
 * @var $model backend\models\form\AdForm
 */
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'barname',
        [
            'attribute' => 'image',
            'format' => 'raw',
            'value' => function($model){
                return "<img style='max-width:200px;max-height:200px' src='" . $model->image . "' >";
            }
        ],
        'url',
        [
            'attribute' => 'status',
            'value' => function($model){
                return Constants::getStatus($model->status);
            }
        ],
        [
            'attribute' => 'location',
            'value' => function($model){
                return Constants::getLocationOpenMethod($model->location);
            }
        ],
        [
            'attribute' => 'target',
            'value' => function($model){
                return Constants::getTargetOpenMethod($model->target);
            }
        ],
    ],
]);
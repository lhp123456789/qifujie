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
 * @var $model backend\models\Article
 */
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'title',
        [
            'attribute' => 'thumb',
            'format' => 'raw',
            'value' => function($model){
                return "<img style='max-width:200px;max-height:200px' src='" . $model->thumb . "' >";
            }
        ],
        [
            'attribute' => 'status',
            'value' => function($model){
                return Constants::getStatusItems($model->status);
            }
        ],
        'sort',
        'author_id',
        'author_name',
        'scan_count',
        [
            'attribute' => 'visibility',
            'value' => function($model){
                return Constants::getYesNoItems($model->visibility);
            }
        ],
        [
            'format' => 'raw',
            'attribute' => 'content',
        ],
        'created_at:datetime',
        'updated_at:datetime',
    ],
]) ?>
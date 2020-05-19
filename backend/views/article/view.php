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
        [
            'attribute' => 'category',
            'value' => function($model){
                return $model->category === null ? "-" : $model->category->name;
            }
        ],
        'title',
        [
            'attribute' => 'thumb',
            'format' => 'raw',
            'value' => function($model){
                return "<img style='max-width:200px;max-height:200px' src='" . $model->thumb . "' >";
            }
        ],
        [
            'attribute' => 'visibility',
            'value' => function($model){
                return Constants::getArticleVisibility($model->visibility);
            }
        ],
        'updated_at:datetime',
    ],
]) ?>
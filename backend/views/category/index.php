<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-21 14:14
 */

/**
 * @var $dataProvider yii\data\ArrayDataProvider
 * @var $model common\models\Category
 */

use backend\grid\DateColumn;
use backend\grid\GridView;
use backend\grid\SortColumn;
use backend\widgets\Bar;
use common\libs\Constants;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use yii\widgets\Pjax;
use common\widgets\JsBlock;

$this->title = "Category";
$this->params['breadcrumbs'][] = Yii::t('app', 'Category');
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget() ?>
                <?php Pjax::begin(['id' => 'pjax']); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'class' => CheckboxColumn::className(),
                        ],
                        [
                            'attribute' => 'id',
                        ],
                        [
                            'attribute' => 'name',
                            'label' => Yii::t('app', 'Name'),
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $column) {
                                return  $model['name'];
                            }
                        ],
                        [
                            'attribute' => 'image',
                            'format' => ['image',
                                [
                                    "width"=>"30px",
                                    "height"=>"30px",
                                ],
                            ],
                            'value' => function($model){
                                $image = call_user_func(function()use($model){
                                    if (strpos($model->image, "/") === 0){
                                        return substr($model->image, 1);
                                    }
                                    return $model->image;
                                });
//                                return "<img style='max-width:200px;max-height:200px' src='" . $logo . "' >";
                                return $image;
                            }
                        ],
                        //                        状态
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                /* @var $model backend\models\Company */
                                return Html::a(Constants::getCategoryStatus($model['status']), ['update', 'id' => $model['id']], [
                                    'class' => 'btn btn-xs btn-rounded ' . ( $model['status'] == Constants::PUBLISH_YES ? 'btn-info' : 'btn-default' ),
                                    'data-confirm' => $model['status'] == Constants::PUBLISH_YES ? Yii::t('app', '确定隐藏该类别吗?') : Yii::t('app', '确定显示该类别吗?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                    'data-params' => [
                                        $model -> formName() . '[status]' => $model['status'] == Constants::PUBLISH_YES ? Constants::PUBLISH_NO : Constants::PUBLISH_YES
                                    ]
                                ]);
                            },
                            'filter' => Constants::getCategoryStatus(),
                        ],
                        [
                            'class' => DateColumn::className(),
                            'label' => Yii::t('app', 'Created At'),
                            'attribute' => 'created_at',
                        ],
                        [
                            'class' => DateColumn::className(),
                            'label' => Yii::t('app', 'Updated At'),
                            'attribute' => 'updated_at',
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'buttons' => [
                                'create' => function ($model) {
                                    return Html::a('<i class="fa  fa-plus" aria-hidden="true"></i> ', Url::to([
                                        'create',
                                        'parent_id' => $model['id']
                                    ]), [
                                        'title' => Yii::t('app', 'Create'),
                                        'data-pjax' => '0',
                                        'class' => 'btn-sm J_menuItem',
                                    ]);
                                }
                            ],
                        ]
                    ]
                ]) ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php JsBlock::begin()?>

<?php JsBlock::end()?>

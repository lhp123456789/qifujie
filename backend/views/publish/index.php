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

$this->title = "我的发布";
$this->params['breadcrumbs'][] = Yii::t('app', '列表');
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
                        ['attribute' => 'id'],
                        [
                            'attribute' => 'company_alias',
                            'label' => Yii::t('app', '公司全称'),
                        ],
                        [
                            'attribute' => 'company_name',
                            'label' => Yii::t('app', '公司简称'),
                        ],
                        [
                            'attribute' => 'p_type_name',
                            'label' => Yii::t('app', '一级类别'),
                        ],
                        [
                            'attribute' => 'type_name',
                            'label' => Yii::t('app', '二级类别'),

                        ],
                            //状态
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                /* @var $model backend\models\Company */
                                if( $model['status'] === null ){
                                    $model['status'] = Constants::COMPANY_ADD_YES;
                                }
                                return Html::a(Constants::getCompanyADDStatus($model['status']), ['update', 'id' => $model['id']], [
                                    'class' => 'btn btn-xs btn-rounded ' . ( $model['status'] == Constants::YESNO_YES ? 'btn-info' : 'btn-default' ),
                                    'data-confirm' => $model['status'] == Constants::YESNO_YES ? Yii::t('app', '确定拒绝该公司的发布吗?') : Yii::t('app', '确定同意该公司的发布吗?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                    'data-params' => [
                                        $model -> formName() . '[status]' => $model['status'] == Constants::YESNO_YES ? Constants::YESNO_NO : Constants::YESNO_YES
                                    ]
                                ]);
                            },
                            'filter' => Constants::getCompanyADDStatus(),
                        ],
                        [
                            'attribute' => 'error_result',
                            'label' => Yii::t('app', '失败原因'),

                        ],
                        [
                            'class' => DateColumn::className(),
                            'attribute' => 'created_at',
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'width' => '170px'
                        ],
                    ]
                ]) ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

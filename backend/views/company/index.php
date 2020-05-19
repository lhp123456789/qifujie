<?php

/**
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchModel backend\models\search\CompanySearch
 */

use backend\grid\DateColumn;
use backend\grid\GridView;
use common\libs\Constants;
use yii\helpers\Html;
use backend\widgets\Bar;
use yii\widgets\Pjax;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;

$this->title = 'Company';
$this->params['breadcrumbs'][] = Yii::t('app', 'CompanyList');

$config = yii\helpers\ArrayHelper::merge(
    require Yii::getAlias("@frontend/config/main.php"),
    require Yii::getAlias("@frontend/config/main-local.php")
);
$prettyUrl = false;
if( isset( $config['components']['urlManager']['enablePrettyUrl'] ) ){
    $prettyUrl = $config['components']['urlManager']['enablePrettyUrl'];
}
$suffix = "";
if( isset( $config['components']['urlManager']['suffix'] ) ){
    $suffix = $config['components']['urlManager']['suffix'];
}
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
                            'attribute' => 'uid',
                            'label' => "用户名",
                            'value' => function($model){
                                if( $model->user === null ){
                                    return "";
                                }
                                return $model->user['username'];
                            }
                        ],
                        [
                            'attribute' => 'company_alias',
                             'label' => "公司全称",
                            'width' => '100',
                            'format' => 'raw',
                        ],
                         [
                            'attribute' => 'company_name',
                             'label' => "公司简称",
                            'width' => '60',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'logo',
                             'format' => ['image',
                                             [
                                                "width"=>"30px",
                                                "height"=>"30px",
                                             ],
                                    ],
                            'value' => function($model){
                                $logo = call_user_func(function()use($model){
                                    if (strpos($model->logo, "/") === 0){
                                        return substr($model->logo, 1);
                                    }
                                    return $model->logo;
                                });
//                                return "<img style='max-width:200px;max-height:200px' src='" . $logo . "' >";
                                return $logo;
                            }
                        ],
//                        状态
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                /* @var $model backend\models\Company */
                                return Html::a(Constants::getCompanyStatus($model['status']), ['update', 'id' => $model['id']], [
                                    'class' => 'btn btn-xs btn-rounded ' . ( $model['status'] == Constants::YESNo_Yes ? 'btn-info' : 'btn-default' ),
                                    'data-confirm' => $model['status'] == Constants::YESNo_Yes ? Yii::t('app', 'Are you sure the company failed the audit?') : Yii::t('app', 'Are you sure the company has passed the audit?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                    'data-params' => [
                                        $model -> formName() . '[status]' => $model['status'] == Constants::YESNo_Yes ? Constants::YESNo_No : Constants::YESNo_Yes
                                    ]
                                ]);
                            },
                            'filter' => Constants::getCompanyStatus(),
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
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

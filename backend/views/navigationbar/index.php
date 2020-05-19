<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-12-05 13:00
 */

/**
 * @var $this yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

use backend\grid\DateColumn;
use backend\grid\GridView;
use backend\grid\StatusColumn;
use common\libs\Constants;
use common\widgets\JsBlock;
use frontend\models\User;
use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use yii\helpers\Html;

$this->title = 'navigationbar';
$this->params['breadcrumbs'][] = Yii::t('app', 'navigationbar');

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
                <?= Bar::widget()?>
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
                            'attribute' => 'barname',
                        ],
                        [
                            'attribute' => 'image',
                                   'format' => ['image',
                                             [
                                                "width"=>"30px",
                                                "height"=>"30px",
                                             ],
                                    ]
                            ],
                        [
                            'attribute' => 'url',
                        ],
                          //状态
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                /* @var $model backend\models\Company */
                                return Html::a(Constants::getNavigationStatus($model['status']), ['update', 'id' => $model['id']], [
                                    'class' => 'btn btn-xs btn-rounded ' . ( $model['status'] == Constants::PUBLISH_YES ? 'btn-info' : 'btn-default' ),
                                    'data-confirm' => $model['status'] == Constants::PUBLISH_YES ? Yii::t('app', '你确定禁用该类别吗?') : Yii::t('app', '你确定激活该类别吗?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                    'data-params' => [
                                        $model -> formName() . '[status]' => $model['status'] == Constants::PUBLISH_YES ? Constants::PUBLISH_NO : Constants::PUBLISH_YES
                                    ]
                                ]);
                            },
                            'filter' => Constants::getNavigationStatus(),
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'width' => '190px'
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-24 12:51
 */
use yii\helpers\Url;

$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Company'), 'url' => Url::to(['index'])],
    ['label' => Yii::t('app', 'UpdateInfo') . Yii::t('app', 'Company')],
];
/**
 * @var $model backend\models\Article
 */
?>
<?= $this->render('_form', [
    'model' => $model,
]);

<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-03 21:12
 */

use yii\helpers\Url;

$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', '我的发布'), 'url' => Url::to(['index'])],
    ['label' => Yii::t('app', 'Update') . Yii::t('app', '编辑')],
];
/**
 * @var $model common\models\Category
 */
?>
<?= $this->render('_form', [
    'model' => $model,
]); ?>
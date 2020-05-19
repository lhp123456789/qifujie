<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-24 17:06
 */

use yii\helpers\Url;

$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', '我的发布'), 'url' => Url::to(['index'])],
    ['label' => Yii::t('app', 'Create')],
];
/**
 * @var $model common\models\Category
 */
?>
<?= $this->render('_form', [
    'model' => $model
]); ?>
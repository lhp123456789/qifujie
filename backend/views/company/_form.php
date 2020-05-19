<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-12-05 13:00
 */

/**
 * @var $this yii\web\View
 * @var $model frontend\models\User
 */

use backend\widgets\ActiveForm;
use common\libs\Constants;
use common\widgets\JsBlock;

$this->title = 'Company';
?>
<div class="col-sm-12">
    <div class="ibox">
        <?= $this->render('/widgets/_ibox-title') ?>
        <div class="ibox-content">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data',
                    'class' => 'form-horizontal'
                ]
            ]); ?>
            <?= $form->field($model, 'uid')
                ->label(Yii::t('app', '用户名'))
                ->dropDownList(\backend\models\Company::getUsersName()) ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'company_name')->textInput(); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'company_alias')->textInput(); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'logo')->imgInput(['style' => 'max-width:200px;max-height:200px']); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'company_url')->textInput(); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'company_phone')->textInput(); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'cusc')->textInput(); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'business_licese')->imgInput(['style' => 'max-width:200px;max-height:200px']); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'card_picture')->imgInput(['style' => 'max-width:200px;max-height:200px']); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'card_pic')->imgInput(['style' => 'max-width:200px;max-height:200px']); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'company_product')->textInput() ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'company_describe')->textInput() ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'status')->radioList(Constants::getCompanyStatus()); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->defaultButtons() ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


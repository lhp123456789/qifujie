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

$this->title = 'navigationbar';
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
            <?= $form->field($model, 'barname')->textInput(); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'url')->textInput(); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'image')->imgInput(['style' => 'max-width:200px;max-height:200px']); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'target')->radioList(Constants::getTargetOpenMethod()); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'location')->radioList(Constants::getLocationOpenMethod()); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'status')->radioList(Constants::getNavigationStatus()); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->defaultButtons() ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php JsBlock::begin() ?>
<script>
    $(document).ready(function () {
        var defaultType = $("select#adform-input_type :selected").val();
        $(".form-group.field-adform-ad").not(".input_"+defaultType).hide().find("input[name=AdForm\\[ad\\]], textarea[name=AdForm\\[ad\\]]").attr('disabled', true);
        $("select#adform-input_type").change(function () {
            var type = parseInt( $(this).val() );
            $(".form-group.field-adform-ad").hide().find("input[name=AdForm\\[ad\\]], textarea[name=AdForm\\[ad\\]]").attr('disabled', true);
            $(".form-group.field-adform-ad.input_"+type).show().attr('name', 'NavigationForm[image]').find("input[name=AdForm\\[ad\\]], textarea[name=AdForm\\[ad\\]]").attr('disabled', false);
        })
    })
</script>
<?php JsBlock::end() ?>

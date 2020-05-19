<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\Category
 */

use backend\widgets\ActiveForm;
use common\helpers\FamilyTree;
use common\libs\Constants;
use common\models\Category;
use yii\helpers\ArrayHelper;
//use common\helpers\Util;

?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin(
                    ['options' => [
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal'
                    ]
                ]); ?>
                <?= $form->field($model, 'p_cid')
                    ->label(Yii::t('app', '父分类名称'))
                    ->dropDownList(\common\models\Publish:: getP_Categories())?>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'cid')
                    ->label(Yii::t('app', '子分类名称'))
                    ->dropDownList(\common\models\Publish::getCategories()) ?>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'comp_id')
                    ->label(Yii::t('app', '公司名'))
                    ->dropDownList(\common\models\Publish::getCompanyName()) ?>
<!--                , [-->
<!--                'prompt' => '请选择公司名',-->
<!--                'onchange'=>'-->
<!--                $.post("/publish/main/cate?id='.'"+$(this).val(),function(data){-->
<!--                $("select#main-aid").html(data);-->
<!--                });',-->
<!--                ])->hint('公司名,必选')-->
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'id')
                    ->label(Yii::t('app', '公司链接'))
                    ->dropDownList(\common\models\Publish::getCompanyUrl()) ?>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'status')->radioList(Constants::getCompanyADDStatus()); ?>
               <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-23 15:49
 */

/**
 * @var $this yii\web\View
 * @var $model backend\models\Article
 */

use backend\widgets\ActiveForm;
use common\models\Category;
use common\libs\Constants;
use common\widgets\JsBlock;
use backend\widgets\Ueditor;
use backend\widgets\webuploader\Webuploader;
use common\helpers\Util;

$this->title = "Articles";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <div class="row form-body form-horizontal m-t">
                    <div class="col-md-12 droppable sortable ui-droppable ui-sortable" style="display: none;">
                    </div>
                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'enctype' => 'multipart/form-data',
                            'class' => 'form-horizontal'
                        ]
                    ]); ?>

                    <!--left start-->
                    <div class="col-md-7 droppable sortable ui-droppable ui-sortable" style="">
<!--                       标题-->
                        <?= $form->field($model, 'title')->textInput(); ?>
<!--                        缩略图-->
                        <?= $form->field($model, 'thumb')->imgInput(['style' => 'max-width:200px;max-height:200px']); ?>
<!--                        副图-->
                        <?= $form->field($model, 'images')->widget(Webuploader::className()); ?>

                        <?= $form->field($model, 'content')->widget(Ueditor::className()) ?>
                    </div>
                    <!--left stop -->
<!--                    右侧分类-->
                    <div class="col-md-5 droppable sortable ui-droppable ui-sortable" style="">
                        <div class="ibox-title">
                            <h5><?= Yii::t('app', 'Category') ?></h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-12 col-sm-offset-1">
                                        <?= $form->field($model, 'cid', ['size'=>10])->label(false)->chosenSelect(Category::getCategoriesName())?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 droppable sortable ui-droppable ui-sortable" style="">
                        <div class="ibox-title">
                            <h5><?= Yii::t('app', 'Other') ?></h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-sm-4">
                                    <?= $form->field($model, 'status', [
                                        'size' => 7,
                                        'labelOptions' => ['class' => 'col-sm-5 control-label']
                                    ])->dropDownList(Constants::getArticleStatus()); ?>
                                </div>
                                <div class="col-sm-4">
                                    <?= $form->field($model, 'visibility', [
                                        'size' => 7,
                                        'labelOptions' => ['class' => 'col-sm-5 control-label']
                                    ])->dropDownList(Constants::getArticleVisibility()); ?>
                                </div>
                            </div>
                            <?php $hide=' hide ';if($model->visibility == Constants::ARTICLE_VISIBILITY_SECRET){$hide='';} ?>
                            <?= $form->defaultButtons(['size' => 12]) ?>
                        </div>
                    </div>
                    <?php $form = ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php JsBlock::begin()?>
    <script>
        $(document).ready(function () {
            $("select#article-visibility").change(function () {
                if( $(this).val() === <?=Constants::ARTICLE_VISIBILITY_SECRET?> ){
                    $("div.field-article-password").removeClass('hide');
                }else{
                    $("div.field-article-password").addClass('hide');
                }
            })
        })
    </script>
<?php JsBlock::end()?>
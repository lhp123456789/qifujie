<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-31 14:17
 */

use common\widgets\JsBlock;
use yii\helpers\Url;

/**
 * @var $statics array
 * @var $this yii\web\View
 */
$this->registerCss("
     .environment .list-group-item > .badge {float: left}
     .environment  li.list-group-item strong {margin-left: 15px}
     ul#notify .list-group-item{line-height:15px}
")
?>
<div class="row">
<!--    业务-->
    <div class="col-sm-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right"><?= Yii::t('app', 'Month') ?></span>
                <h5><?= Yii::t('app', '类别') ?></h5>
            </div>
            <div class="ibox-content openContab" href="<?=Url::to(['category/index'])?>" title="<?= Yii::t('app', '类别')?>" style="cursor: pointer">
                <h1 class="no-margins"><?= $statics['CATEGORY'][0] ?></h1>
                <div class="stat-percent font-bold text-success"><?= $statics['CATEGORY'][1] ?>% <i class="fa fa-bolt"></i></div>
                <small><?= Yii::t('app', 'Total') ?></small>
            </div>
        </div>
    </div>
<!--    评论-->
    <div class="col-sm-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right"><?= Yii::t('app', 'Today') ?></span>
                <h5><?= Yii::t('app', 'Comments') ?></h5>
            </div>
            <div class="ibox-content openContab" href="<?=Url::to(['comment/index'])?>" title="<?= Yii::t('app', 'Comments')?>" style="cursor: pointer">
                <h1 class="no-margins"><?= $statics['COMMENT'][0] ?></h1>
                <div class="stat-percent font-bold text-info"><?= $statics['COMMENT'][1] ?>% <i class="fa fa-level-up"></i></div>
                <small><?= Yii::t('app', 'Total') ?></small>
            </div>
        </div>
    </div>
<!--    用户-->
    <div class="col-sm-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-primary pull-right"><?= Yii::t('app', 'Month') ?></span>
                <h5><?= Yii::t('app', 'Users') ?></h5>
            </div>
            <div class="ibox-content openContab" href="<?=Url::to(['user/index'])?>" title="<?= Yii::t('app', 'Users')?>" style="cursor: pointer">
                <h1 class="no-margins"><?= $statics['USER'][0] ?></h1>
                <div class="stat-percent font-bold text-navy"><?= $statics['USER'][1] ?>% <i class="fa fa-level-up"></i></div>
                <small><?= Yii::t('app', 'Total') ?></small>
            </div>
        </div>
    </div>
<!--    友情链接-->
    <div class="col-sm-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right"><?= Yii::t('app', 'Month') ?></span>
                <h5><?= Yii::t('app', 'Friendly Links') ?></h5>
            </div>
            <div class="ibox-content openContab" href="<?=Url::to(['friendly-link/index'])?>" title="<?= Yii::t('app', 'Friendly Links')?>" style="cursor: pointer">
                <h1 class="no-margins"><?= $statics['FRIEND_LINK'][0] ?></h1>
                <div class="stat-percent font-bold text-info"><?= $statics['FRIEND_LINK'][1] ?>% <i class="fa fa-level-up"></i></div>
                <small><?= Yii::t('app', 'Total') ?></small>
            </div>
        </div>
    </div>
</div>

<div class="row">


    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?= Yii::t('app', 'Latest Comments') ?></h5>
                <div class="ibox-tools">
                    <a class="openContab" title="<?=Yii::t('app', 'Comments')?>" target="_blank" href="<?=Url::to(['comment/index'])?>"><?= Yii::t('app', 'More')?></a>
                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    <a class="close-link"><i class="fa fa-times"></i></a>
                </div>
            </div>
            <div class="ibox-content">
                <div>
                    <div class="feed-activity-list">
                        <?php
                        foreach ($comments as $comment) {
                            ?>
                            <div class="feed-element">
                                <a class="pull-left"><img alt="image" class="img-circle" src="https://secure.gravatar.com/avatar/<?= md5($comment->email) ?>?s=50"></a>
                                <div class="media-body ">
                                    <small class="pull-right"><?= Yii::$app->getFormatter()->asRelativeTime($comment->created_at) ?></small>
                                    <strong><?= $comment->nickname ?></strong>
                                    <br>
                                    <small class="text-muted"><?= Yii::$app->getFormatter()->asDate($comment->created_at) ?> <?=Yii::t('app', 'at')?> <a class="openContab" data-index="0" title="<?=yii::t('app',"Articles")?>" href="<?= isset($comment->article->id) ? Url::toRoute(['article/view-layer', 'id'=>$comment->article->id]) : '#' ?>"><?= isset($comment->article->title) ? $comment->article->title : '' ?></a></small>
                                    <div data-index="0" class="openContab well" href="<?=Url::toRoute(['comment/index']) ?>" title="<?= Yii::t('app', 'Comments')?>" style="cursor: pointer">
                                        <?= $comment->content ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php JsBlock::begin() ?>
<script>
$(document).ready(function () {

    $.ajax({
        dataType:"jsonp",
        url:"",
        success:function (dataAll) {

        },
        error:function (data) {

        }
    });
})
</script>
<?php JsBlock::end() ?>

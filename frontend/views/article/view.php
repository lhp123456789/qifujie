<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-02 22:55
 */
/**
 * @var $this yii\web\View
 * @var $model frontend\models\Article
 * @var $commentModel frontend\models\Comment
 * @var $prev frontend\models\Article
 * @var $next frontend\models\Article
 * @var $recommends array
 * @var $commentList array
 */
use frontend\widgets\ArticleListView;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use frontend\assets\ViewAsset;
use common\widgets\JsBlock;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = $model->title;
$this->registerMetaTag(['name' => 'tags', 'content' => call_user_func(function()use($model) {
    $tags = '';
    foreach ($model->articleTags as $tag) {
        $tags .= $tag->value . ',';
    }
    return rtrim($tags, ',');
    }
)], 'tags');
$this->registerMetaTag(['property' => 'article:author', 'content' => $model->author_name]);
$categoryName = $model->category ? $model->category->name : Yii::t('app', 'uncategoried');

ViewAsset::register($this);
?>



<div class="content-wrap">
    <div class="content">
        <div class="breadcrumbs">
            <a title="<?=Yii::t('frontend', 'Return Home')?>" href="<?= Yii::$app->getHomeUrl() ?>"><i class="fa fa-home"></i></a>
            <small>&gt;</small>
            <a href="<?= Url::to(['article/index', 'cat' => $categoryName]) ?>"><?= $categoryName ?></a>
            <small>&gt;</small>
            <span class="muted"><?= $model->title ?></span>
        </div>
        <header class="article-header">
            <h1 class="article-title"><a href="<?= Url::to(['article/view', 'id' => $model->id]) ?>"><?= $model->title ?></a></h1>
            <div class="meta">
                <span id="mute-category" class="muted"><i class="fa fa-list-alt"></i>
                    <a href="<?= Url::to([
                        'article/index',
                        'cat' => $categoryName
                    ]) ?>"> <?= $categoryName ?>
                    </a>
                </span>
            </div>
        </header>
    </div>
</div>
<?= $this->render('/widgets/_sidebar') ?>
<?php JsBlock::begin(); ?>
<script type="text/javascript">
    SyntaxHighlighter.all();
    $(document).ready(function () {
        $.ajax({
            url:"<?=Url::to(['article/view-ajax'])?>",
            data:{id:<?=$model->id?>},
            success:function (data) {
                $("span.count").html(data.likeCount);
                $("span#scanCount").html(data.scanCount);
                $("span#commentCount").html(data.commentCount);
            }
        });
    })
</script>
<?php JsBlock::end(); ?>

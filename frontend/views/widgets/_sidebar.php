<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-06-21 14:26
 */

use common\models\meta\ArticleMetaTag;
use common\models\Options;
use frontend\models\Article;
use yii\helpers\Url;
use frontend\models\Comment;
use frontend\models\FriendlyLink;

?>
<aside class="sidebar">
<!--    第三方接口-->
    <div class="widget widget_text">
        <div class="textwidget">
            <div class="social">
                <a href="" rel="external nofollow" title="" target="_blank" data-original-title="新浪微博"><i class="sinaweibo fa fa-weibo"></i></a>
                <a class="weixin" data-original-title="" title=""><i class="weixins fa fa-weixin"></i>
                    <div class="weixin-popover">
                        <div class="popover bottom in">
                            <div class="arrow"></div>
                            <div class="popover-title">
                                <?=Yii::t('frontend', 'Follow Wechat')?>
                            </div>
                            <div class="popover-content">
                                <img src="<?=Yii::$app->getRequest()->getBaseUrl()?>/static/images/weixin.jpg">
                            </div>
                        </div>
                    </div>
                </a>
                <a href="" rel="external nofollow" title="" target="_blank" data-original-title="Email"><i class="email fa fa-envelope-o"></i></a>
            </div>
        </div>
    </div>
<!--    本地热门行业-->
    <div class="widget d_postlist">
        <div class="title">
            <h2>
                <sapn class="title_span"><?= Yii::t('frontend', 'Local hot industry') ?></sapn>
            </h2>
        </div>
        <ul>
            <?php
            $articles = Article::find()->where(['status' => 1])->limit(8)->orderBy("sort asc")->all();
            foreach ($articles as $article) {
                /** @var $article \frontend\models\Article */
                $url = Url::to(['article/view', 'id' => $article->id]);
                $imgUrl = $article->getThumbUrlBySize(125, 86);
                $article->created_at = Yii::$app->formatter->asDate($article->created_at);
                echo "<li>
                            <a href=\"{$url}\" title=\"{$article->title}\">
                                <span class=\"thumbnail\"><img src=\"{$imgUrl}\" alt=\"{$article->title}\"></span>
                                <span class=\"text\">{$article->title}</span>
                                <span class=\"muted\">{$article->created_at}</span>
                            </a>
                      </li>";
            }
            ?>
        </ul>
    </div>
<!--    热门服务推荐-->
    <div class="widget d_postlist">
        <div class="title">
            <h2>
                <sapn class="title_span"><?= Yii::t('frontend', 'Popular service recommendation') ?></sapn>
            </h2>
        </div>
        <ul>
            <?php
            $articles = Article::find()->where(['status' => 1])->limit(8)->orderBy("sort asc")->all();
            foreach ($articles as $article) {
                /** @var $article \frontend\models\Article */
                $url = Url::to(['article/view', 'id' => $article->id]);
                $imgUrl = $article->getThumbUrlBySize(125, 86);
                $article->created_at = Yii::$app->formatter->asDate($article->created_at);
                echo "<li>
                        <a href=\"{$url}\" title=\"{$article->title}\">
                            <span class=\"thumbnail\"><img src=\"{$imgUrl}\" alt=\"{$article->title}\"></span>
                            <span class=\"text\">{$article->title}</span>
                            <span class=\"muted\">{$article->created_at}</span>
                        </a>
                      </li>";
            }
            ?>
        </ul>
    </div>
<!--    便民服务-->
    <div class="widget d_comment">
        <div class="title">
            <h2>
                <sapn class="title_span"><?= Yii::t('frontend', 'handy service for the public') ?></sapn>
            </h2>
        </div>
        <ul>
            <?php
            $comments = Comment::find()->orderBy("id desc")->limit(5)->all();
            foreach ($comments as $v) {
                ?>
                <li>
                    <a href="<?= Url::to(['article/view', 'id' => $v['aid'], '#' => 'comment-' . $v['id']]) ?>"
                       title="">
                        <img data-original="<?=Yii::$app->getRequest()->getBaseUrl()?>/static/images/comment-user-avatar.png" class="avatar avatar-72" height="50"
                             width="50" src="" style="display: block;">
                        <div class="muted">
                            <i><?= $v['nickname'] ?></i>&nbsp;&nbsp;<?= Yii::$app->formatter->asRelativeTime($v['created_at']) ?>
                            (<?= Yii::$app->formatter->asTime($v['created_at']) ?>)<?= Yii::t('frontend', ' said') ?>
                            ：<br><?= $v['content'] ?></div>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
<!--    友情链接-->
    <div class="widget widget_text">
        <div class="title">
            <h2>
                <sapn class="title_span"><?= Yii::t('frontend', 'Friendly Links') ?></sapn>
            </h2>
        </div>
        <div class="textwidget">
            <div class="d_tags_1">
                <?php
                $links = FriendlyLink::find()->where(['status' => FriendlyLink::DISPLAY_YES])->orderBy("sort asc, id asc")->asArray()->all();
                foreach ($links as $link) {
                    echo "<a target='_blank' href='{$link['url']}'>{$link['name']}</a>";
                }
                ?>
            </div>
        </div>
    </div>
</aside>

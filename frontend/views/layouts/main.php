<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use frontend\widgets\MenuView;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title>企服界</title>
    <?php $this->head() ?>
     <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=10,IE=9,IE=8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <script>
        window._deel = {
            name: '企服界',
            url: '<?=Yii::$app->getHomeUrl()?>',
            comment_url: '<?=Url::to(['article/comment'])?>',
            ajaxpager: '',
            commenton: 0,
            roll: [4,]
        }
    </script>
</head>
<?php $this->beginBody() ?>
<body class="home blog">
<?= $this->render('/widgets/_flash') ?>
<header id="masthead" class="site-header">
    <nav id="top-header">
        <div class="top-nav">
            <div id="user-profile">
                <span class="nav-set">
                    <span class="nav-login">
                        <?php
                        if (Yii::$app->getUser()->getIsGuest()) {
                            ?>
                            <a href="<?= Url::to(['site/login']) ?>" class="signin-loader"><?= Yii::t('frontend', 'Hi, Log in') ?></a>&nbsp; &nbsp;
                            <a href="<?= Url::to(['site/signup']) ?>" class="signup-loader"><?= Yii::t('frontend', 'Sign up') ?></a>
                        <?php } else { ?>
                            Welcome, <?= Html::encode(Yii::$app->user->identity->username) ?>
                            <a href="<?= Url::to(['site/logout']) ?>" class="signup-loader"><?= Yii::t('frontend', 'Log out') ?></a>
                        <?php } ?>
                    </span>
                </span>
            </div>
        </div>
    </nav>
    <div id="nav-header" class="">
        <div id="top-menu">
            <div id="top-menu_1">
                <hgroup class="logo-site" style="margin-top: 10px;">
                    <h1 class="site-title">
                        <a href="<?= Yii::$app->getHomeUrl() ?>">
                            <img src="<?=Yii::$app->getRequest()->getBaseUrl()?>/static/images/head.jpg" alt="" style="width: 50px;height: 50px">
                        </a>
                    </h1>
                </hgroup>
                <form id="searchform" action="<?= Url::toRoute('search/index') ?>" method="get">
                    <input id="s" type="text" name="q" value="<?= Html::encode(Yii::$app->getRequest()->get('q')) ?>" required="" placeholder="<?= Yii::t('frontend', 'Please input keywords') ?>" name="s" style="width: 560px;margin-left: 125px">
                    <button id="searchsubmit" type="submit"><?= Yii::t('frontend', 'Search') ?></button>
                </form>
            </div>
        </div>
    </div>
</header>
<!--内容-->
<section class="container">
    <div class="speedbar" ></div>
    <?= $content ?>
</section>
<!--底部-->
<div class="branding branding-black">
    <div class="container_f">
        <h2><?= Yii::t('frontend', 'Effective,Professional,Conform to SEO') ?></h2>
        <a class="btn btn-lg" href="" target="_blank"><?= Yii::t('frontend', 'Contact us') ?></a>
    </div>
</div>
<div class="rollto" style="display: none;">
    <button class="btn btn-inverse" data-type="totop" title="back to top"><i class="fa fa-arrow-up"></i></button>
</div>

</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $type string
 * @var $category string
 */

use common\models\Options;
use frontend\models\Article;
use frontend\widgets\ArticleListView;
use frontend\widgets\ScrollPicView;
use common\widgets\JsBlock;
use frontend\assets\IndexAsset;
use yii\data\ArrayDataProvider;

IndexAsset::register($this);
$this->title = ( !empty($category) ? $category . " - " : "" ) ;

?>
<div class="content-wrap">
<!--    左侧-->
    <div class="content">
<!--        --><?php // echo $catelist?>
    </div>
</div>
<!--右侧-->
<!--继承模板-->
<?= $this->render('/widgets/_sidebar') ?>
<?php JsBlock::begin() ?>
<script>
    $(function () {
        var mx = document.body.clientWidth;
        $(".slick").responsiveSlides({
            auto: true,
            pager: true,
            nav: true,
            speed: 70,
            timeout: 7000,
            maxwidth: mx,
            namespace: "centered-btns"
        });
    });
</script>
<?php JsBlock::end() ?>

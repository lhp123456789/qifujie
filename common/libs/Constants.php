<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-10-16 17:15
 */

namespace common\libs;

use Yii;
use yii\base\InvalidParamException;

class Constants
{
    const YesNo_Yes = 1;
    const YesNo_No = 0;

    public static function getYesNoItems($key = null)
    {
        $items = [
            self::YesNo_Yes => Yii::t('app', 'Yes'),
            self::YesNo_No => Yii::t('app', 'No'),
        ];
        return self::getItems($items, $key);
    }

    public static function getWebsiteStatusItems($key = null)
    {
        $items = [
            self::YesNo_Yes => Yii::t('app', 'Opened'),
            self::YesNo_No => Yii::t('app', 'Closed'),
        ];
        return self::getItems($items, $key);
    }

    const COMMENT_INITIAL = 0;
    const COMMENT_PUBLISH = 1;
    const COMMENT_RUBISSH = 2;

    public static function getCommentStatusItems($key = null)
    {
        $items = [
            self::COMMENT_INITIAL => Yii::t('app', 'Not Audited'),
            self::COMMENT_PUBLISH => Yii::t('app', 'Passed'),
            self::COMMENT_RUBISSH => Yii::t('app', 'Unpassed'),
        ];
        return self::getItems($items, $key);
    }




    /*****************************************************************/
    const CATEGORY_YES = 1;
    const CATEGORY_NO = 2;

    /*类别状态审核*/
    public static function getCategoryStatus($key = null)
    {
        $items = [
            self::PUBLISH_YES => Yii::t('app', 'Publish'),
            self::PUBLISH_NO => Yii::t('app', 'Draft'),
        ];
        return self::getItems($items, $key);
    }
    /*类别状态展示*/
    public static function getStatus($key = null)
    {
        $items = [
            self::CATEGORY_YES => Yii::t('app', '显示'),
            self::CATEGORY_NO => Yii::t('app', '隐藏'),

        ];
        return self::getItems($items, $key);
    }

    const LOCATION_bar = 1;
    const LOCATION_bottom = 2;
    const LOCATION_middle = 3;
    /*类别前台位置更改操作*/
    public static function getLocationMethod($key = null)
    {
        $items = [
            self::LOCATION_bar => Yii::t('app', '顶部'),
            self::LOCATION_middle => Yii::t('app', '中间'),
            self::LOCATION_bottom => Yii::t('app', '底部'),
        ];
        return self::getItems($items, $key);
    }

    /*****************************************************************/
    const HTTP_METHOD_ALL = 0;
    const HTTP_METHOD_GET = 1;
    const HTTP_METHOD_POST = 2;

    public static function getHttpMethodItems($key = null)
    {
        $items = [
            self::HTTP_METHOD_ALL => 'all',
            self::HTTP_METHOD_GET => 'get',
            self::HTTP_METHOD_POST => 'post',
        ];
        return self::getItems($items, $key);
    }
    /*****************************************************************/
    const PUBLISH_YES = 1;
    const PUBLISH_NO = 2;
/*导航状态审核*/
    public static function getNavigationStatus($key = null)
    {
        $items = [
            self::PUBLISH_YES => Yii::t('app', 'Publish'),
            self::PUBLISH_NO => Yii::t('app', 'Draft'),
        ];
        return self::getItems($items, $key);
    }

    const TARGET_BLANK = '_blank';
    const TARGET_SELF = '_self';
    /*导航是否本页面跳转状态修改*/
    public static function getTargetOpenMethod($key = null)
    {
        $items = [
            self::TARGET_BLANK => Yii::t('app', 'Yes'),
            self::TARGET_SELF => Yii::t('app', 'No'),
        ];
        return self::getItems($items, $key);
    }
    const LOCATION_BAR = 1;
    const LOCATION_BOTTOM = 2;
    /*导航location位置更改*/
    public static function getLocationOpenMethod($key = null)
    {
        $items = [
            self::LOCATION_BAR => Yii::t('app', '顶部'),
            self::LOCATION_BOTTOM => Yii::t('app', '底部'),
        ];
        return self::getItems($items, $key);
    }

    /*****************************************************************/
    /*公司状态审核*/
    const COMPANY_YES = 1;
    const COMPANY_ASK = 2;
    const COMPANY_NO = 3;
    const YESNo_Yes = 1;
    const YESNo_No = 3;
    public static function getCompanyStatus($key = null)
    {
        $items = [
            self::COMPANY_YES => Yii::t('app', 'Pass'),
            self::COMPANY_NO => Yii::t('app', 'Defeat'),
            self::COMPANY_ASK => Yii::t('app', 'Not Audited'),
            self::YesNo_No => Yii::t('app', 'No'),
        ];
        return self::getItems($items, $key);
    }
    const Status_Enable = 1;
    const Status_Desable = 0;
    /*公司状态展示*/
    public static function getStatusItems($key = null)
    {
        $items = [
            self::COMPANY_YES => Yii::t('app', 'Enable'),
            self::COMPANY_ASK => Yii::t('app', '待审核'),
            self::COMPANY_NO => Yii::t('app', 'Disable'),
        ];
        return self::getItems($items, $key);
    }

    /*****************************************************************/
    const COMPANY_ADD_YES = 1;
    const COMPANY_ADD_ASK = 2;
    const COMPANY_ADD_NO = 3;
    const YESNO_YES = 1;
    const YESNO_ASK =2;
    const YESNO_NO = 3;
    /*我的发布状态审核*/
    public static function getCompanyADDStatus($key = null)
    {
        $items = [
            self::COMPANY_ADD_YES => Yii::t('app', '发布'),
            self::COMPANY_ADD_NO => Yii::t('app', '失败'),
            self::COMPANY_ADD_ASK => Yii::t('app', 'Not Audited'),
        ];
        return self::getItems($items, $key);
    }
    /*我的发布状态展示*/
    public static function getADDStatusItems($key = null)
    {
        $items = [
            self::COMPANY_ADD_YES => Yii::t('app', '发布'),
            self::COMPANY_ADD_ASK => Yii::t('app', '待审核'),
            self::COMPANY_ADD_NO => Yii::t('app', '失败'),
        ];
        return self::getItems($items, $key);
    }

    /*****************************************************************/
    public static function getUserStatus($key = null)
    {
        $items = [
            self::COMPANY_YES => Yii::t('app', 'EnterPass'),
            self::COMPANY_NO => Yii::t('app', '入驻失败'),
            self::COMPANY_ASK => Yii::t('app', 'Not Audited'),
            self::YesNo_No => Yii::t('app', 'No'),
        ];
        return self::getItems($items, $key);
    }

    /*****************************************************************/
    const INPUT_INPUT = 1;
    const INPUT_TEXTAREA = 2;
    const INPUT_UEDITOR = 3;
    const INPUT_IMG = 4;

    public static function getInputTypeItems($key = null)
    {
        $items = [
            self::INPUT_INPUT => 'input',
            self::INPUT_TEXTAREA => 'textarea',
            self::INPUT_UEDITOR => 'ueditor',
            self::INPUT_IMG => 'image',
        ];
        return self::getItems($items, $key);
    }

    const ARTICLE_VISIBILITY_PUBLIC = 1;
    const ARTICLE_VISIBILITY_COMMENT = 2;
    const ARTICLE_VISIBILITY_SECRET = 3;
    const ARTICLE_VISIBILITY_LOGIN = 4;

    public static function getArticleVisibility($key = null)
    {
        $items = [
            self::ARTICLE_VISIBILITY_PUBLIC => Yii::t('app', 'Public'),
            self::ARTICLE_VISIBILITY_COMMENT => Yii::t('app', 'Reply'),
            self::ARTICLE_VISIBILITY_SECRET => Yii::t('app', 'Password'),
            self::ARTICLE_VISIBILITY_LOGIN => Yii::t('app', 'Login'),
        ];
        return self::getItems($items, $key);
    }



    private static function getItems($items, $key = null)
    {
        if ($key !== null) {
            if (key_exists($key, $items)) {
                return $items[$key];
            }
            throw new InvalidParamException( 'Unknown key:' . $key );
        }
        return $items;
    }

    const AD_IMG = 1;
    const AD_VIDEO = 2;
    const AD_TEXT = 3;

    public static function getAdTypeItems($key = null)
    {
        $items = [
            self::AD_IMG => 'image',
            self::AD_VIDEO => 'video',
            self::AD_TEXT => 'text',
        ];
        return self::getItems($items, $key);
    }
}

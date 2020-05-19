<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-10-16 17:15
 */

namespace common\models;

use common\helpers\Util;
use feehi\cdn\TargetAbstract;
use Yii;
use common\libs\Constants;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

class Company extends \yii\db\ActiveRecord
{
    const STATUS = 2;
    const SINGLE_PAGE = 2;
    const ARTICLE_PUBLISHED = 1;
    const ARTICLE_DRAFT = 0;
    /**
     * 需要截取的缩略图尺寸
     */
    public static $thumbSizes = [
    ["w"=>220, "h"=>150],//logo
    ["w"=>168, "h"=>112],//营业执照
    ["w"=>168, "h"=>112],//身份证正反
    ["w"=>168, "h"=>112],//
];

    /**
     * @var array
     */
    public $images;
    public $username;
    public $web_url;
    public $uid;

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['company_name', 'status'], 'required'],
            [['logo','business_licese','card_picture','card_pic'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, webp'],
            [['company_product','company_describe'], 'string'],
            [['logo'], 'safe'],
            [["uid", 'created_at', 'updated_at'], 'safe'],
            [['company_name', 'company_product', 'logo','company_describe','business_licese','card_picture','card_pic'], 'string', 'max' => 255],
            [['status'], 'default', 'value'=>self::STATUS, 'on'=>'company'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {//这个方法表示需要表示哪些字段验证，比如user model，在注册时候，username是必填，
        //但是修改时却不是，所以这
        //起了场景的概念。注意看，你有一个场景叫company，yii2在默认时有一个场景叫default，
        //现在你重写这个方法就只有compnay这一个场景了，而你指定default场景，所以找不到
        return [
            'company' => [
                'username',
                'company_name',
                'company_alias',
                'logo',
                'company_url',
                'company_personner',
                'company_phone',
                'cusc',
                'id_number',
                'created_at',
                'updated_at',
                'business_licese',
                'card_picture',
                'card_pic',
                'company_product',
                'company_describe',
                'status',
                'images',
//                'template'
            "uid",
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' =>Yii::t('app','CompanyUser'),
            'company_name' => Yii::t('app', 'Company Name'),
            'company_alias' => Yii::t('app', 'Company Alias'),
            'logo' => Yii::t('app', 'Logo'),
            'status' => Yii::t('app', 'Status'),
            'company_url' => Yii::t('app', 'Company Url'),
            'company_personner' => Yii::t('app', 'Company Personnner'),
            'company_phone' => Yii::t('app', 'Company Phone'),
            'cusc' => Yii::t('app', 'Cusc'),
            'id_number' => Yii::t('app', 'Id Number'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'business_licese' => Yii::t('app', 'Business Licese'),
            'card_picture' => Yii::t('app', 'Card Picture'),
            'card_pic' => Yii::t('app', 'Card Pic'),
            'company_product' => Yii::t('app', 'Company Product'),
            'company_describe' => Yii::t('app', 'Company Describe'),
        ];
    }

    public function beforeSave($insert)
    {
        $path =  Yii::getAlias('@uploads/company/images/');
        Util::handleModelSingleFileUpload($this, 'logo',$insert,$path, ['deleteOldFile'=>true]);
        Util::handleModelSingleFileUpload($this, 'business_licese', $insert, $path, ['deleteOldFile'=>true]);
        Util::handleModelSingleFileUpload($this, 'card_picture',$insert, $path, ['deleteOldFile'=>true]);
        Util::handleModelSingleFileUpload($this, 'card_pic',$insert, $path, ['deleteOldFile'=>true]);
        $this->setAttribute("logo", $this->logo);
        $this->setAttribute("business_licese", $this->business_licese);
        $this->setAttribute("card_picture", $this->card_picture);
        $this->setAttribute("card_pic", $this->card_pic);
        $this->setAttribute("uid", $this->uid);
        return parent::beforeSave($insert);
    }
    public function afterFind()
    {
        $this->logo = $this->getAttribute("logo");
        if ($this->logo) {
            $cdn = Yii::$app->get('cdn');
            $this->logo = $cdn->getCdnUrl($this->logo);
        }


        parent::afterFind();
    }

    public function getThumbUrlBySize($width='', $height='')
    {
        if( empty($width) || empty($height) ){
            return $this->logo;
        }
        if( empty($this->logo) ){//未配图
            return $this->logo = '/images/' . rand(1, 10) . '.jpg';
        }
        static $str = null;
        if( $str === null ) {
            $str = "";
            foreach (self::$thumbSizes as $temp){
                $str .= $temp['w'] . 'x' . $temp['h'] . '---';
            }
        }
        if( strpos($str, $width . 'x' . $height) !== false ){
            $dotPosition = strrpos($this->logo, '.');
            $thumbExt = "@" . $width . 'x' . $height;
            if( $dotPosition === false ){
                return $this->logo . $thumbExt;
            }else{
                return substr_replace($this->logo,$thumbExt, $dotPosition, 0);
            }
        }
        return Yii::$app->getRequest()->getBaseUrl() . '/timthumb.php?' . http_build_query(['src'=>$this->logo, 'h'=>$height, 'w'=>$width, 'zc'=>0]);
    }
    
}

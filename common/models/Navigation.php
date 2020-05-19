<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace common\models;

use common\helpers\Util;

use feehi\cdn\TargetAbstract;
use Yii;
use backend\models\form\NavigationForm;
use common\libs\Constants;
use common\helpers\FileDependencyHelper;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

class Navigation extends \yii\db\ActiveRecord
{
    const Target = "_blank";
    const STATUS = 1;
    const CUSTOM_AUTOLOAD_NO = 0;
    const CUSTOM_AUTOLOAD_YES = 1;
    public static $thumbSizes = [
        ["w"=>168, "h"=>112]
    ];
    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%navigationbar}}';
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['barname'], 'required'],
            [['barname'], 'unique'],
            [['image'], 'string'],
            [['target','location']],
            [['image'], 'default', 'value' => ''],
            [['status'], 'default', 'value'=>self::STATUS, 'on'=>'navigationbar']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'barname' => Yii::t('app', 'Name'),
            'image' => Yii::t('app', 'Images'),
            'input_type' => Yii::t('app', 'Input Type'),
            'autoload' => Yii::t('app', 'Autoload'),
            'url' => Yii::t('app', 'Url'),
            'location'=> Yii::t('app', '位置'),
            'status' => Yii::t('app', '状态'),
        ];
    }

    /**
     * @return array
     */
    public function getNames()
    {
        return array_keys($this->attributeLabels());
    }


    public function afterFind()
    {
        $this->image = $this->getAttribute("image");
        if ($this->image) {
            /** @var TargetAbstract $cdn */
            $cdn = Yii::$app->get('cdn');
            $this->image = $cdn->getCdnUrl($this->image);
        }
        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        $object = Yii::createObject([
            'class' => FileDependencyHelper::className(),
//            'fileName' => 'options.txt',
            'fileName' => 'navigations.txt',
        ]);
        $object->updateFile();
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeValidate()
    {
        if ($this->image !== "0") {//为0表示需要删除图片，Util::handleModelSingleFileUpload()会有判断删除图片
            $this->image = UploadedFile::getInstance($this, "image");
        }
        return parent::beforeValidate();
    }

    public static function getAdByName($barname)
    {
        $image = NavigationForm::findOne(['target'=>self::Target, 'barname'=>$barname]);
        $image === null && $image = Yii::createObject( NavigationForm::className() );

        return $image;
    }


    public function getThumbUrlBySize($width='', $height='')
    {
        if( empty($width) || empty($height) ){
            return $this->image;
        }
        if( empty($this->image) ){//未配图
            return $this->image = '@uploads/navigationbar/images/' . rand(1, 10) . '.jpg';
        }
        static $str = null;
        if( $str === null ) {
            $str = "";
            foreach (self::$thumbSizes as $temp){
                $str .= $temp['w'] . 'x' . $temp['h'] . '---';
            }
        }
        if( strpos($str, $width . 'x' . $height) !== false ){
            $dotPosition = strrpos($this->image, '.');
            $thumbExt = "@" . $width . 'x' . $height;
            if( $dotPosition === false ){
                return $this->image . $thumbExt;
            }else{
                return substr_replace($this->image,$thumbExt, $dotPosition, 0);
            }
        }
        return Yii::$app->getRequest()->getBaseUrl() . '/timthumb.php?' . http_build_query(['src'=>$this->image, 'h'=>$height, 'w'=>$width, 'zc'=>0]);
    }

}

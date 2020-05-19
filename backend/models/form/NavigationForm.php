<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-12-05 12:47
 */

namespace backend\models\form;

use common\helpers\Util;
use Yii;
use common\libs\Constants;


class NavigationForm extends \common\models\Navigation
{
    public $input_type;
    public $autoload;
    public $image;
    public $created_at;
    public $updated_at;
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'barname' => Yii::t('app', 'SIGN'),
            'image' => Yii::t('app', 'Images'),
            'url' => Yii::t('app', 'Jump Link'),
            'autoload' => Yii::t('app', 'Nstatus'),
            'target' => Yii::t('app', 'Target'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['barname'], 'unique'],
            [[ 'autoload','created_at'], 'integer'],
            [[ 'url', 'target'], 'string'],
            [['location','target']],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, webp']
        ];
    }


    public function beforeSave($insert)
    {
        $this->target = self::Target;
        Util::handleModelSingleFileUploadAbnormal($this, 'image', '@uploads/Navigationbar/images/', $this->getOldAttribute('image'), ['deleteOldFile'=>true]);
        $this->setAttribute("image", $this->image);
        /*$image = [
            'image' => $this->image,
        ];
        $this -> image = json_encode($image);
        */
        return parent::beforeSave($insert);
    }


    public function afterFind()
    {
        $image = json_decode($this -> image);
        if( $this->input_type !== Constants::AD_TEXT){
            /** @var $cdn \feehi\cdn\TargetAbstract */
//            $cdn = Yii::$app->get('cdn');
//            $this->image = $cdn->getCdnUrl($image->image);
//            $this->image = $image->image;
        }else{
            $this->image = $image->image;
        }
        $this->setOldAttributes([
            'id' => $this->id,
            'barname' => $this->barname,
            'image' => $this->image,
            'input_type' => $this->input_type,
            'autoload' => $this->autoload,
            'url' => $this->url,
            'target' => $this->target,
        ]);
        parent::afterFind();
    }

    public function beforeDelete()
    {
        if( !empty( $this->image ) ){
            Util::deleteThumbnails(Yii::getAlias('@uploads/navigationbar/images/') . $this->image, self::$thumbSizes, true);
        }

        return parent::beforeDelete();
    }
}
<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-08-30 18:10
 */
namespace wechat\models;

use Yii;
use yii\behaviors\TimestampBehavior;

class category extends \yii\db\ActiveRecord
{

    /**
     * @表名
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @路由规则
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            ['name', 'string'],
         

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app','Barname'),
            'image' => Yii::t('app', 'Image'),
    
            
        ];
    }


}
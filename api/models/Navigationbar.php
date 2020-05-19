<?php

namespace api\models;
use Yii;
use yii\behaviors\TimestampBehavior;

class Navigationbar extends \yii\db\ActiveRecord
{

    /**
     * @表名
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
     * @路由规则
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            ['barname', 'string', 'max' => 20],
            ['url','string','max'=> 200],
            ['image','string', 'max' => 255],
            ['target','string', 'max' => 100],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'barname' => Yii::t('app','Barname'),
            'image' => Yii::t('app', 'Image'),
            'url' => Yii::t('app', 'Url'),
            'status' => Yii::t('app', 'Status'),
            'target' => Yii::t('app', 'Target'),
        ];
    }


}

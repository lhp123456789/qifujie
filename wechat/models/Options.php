<?php

namespace wechat\models;
use Yii;
use yii\behaviors\TimestampBehavior;

class Options extends \yii\db\ActiveRecord
{

    /**
     * @表名
     */
    public static function tableName()
    {
        return '{{%options}}';
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
            [['value'], 'string'],
            [['value'], 'default', 'value' => ''],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'value' => Yii::t('app', 'Value'),
        ];
    }


}

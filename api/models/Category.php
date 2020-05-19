<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-08-30 18:10
 */
namespace api\models;
use Yii;
use yii\behaviors\TimestampBehavior;
class Category extends \common\models\Category
{
    public function fields()
    {
        return [
            'name',
            "parent_id" => function($model){
                return $model->Category->parent_id;
            }
        ];
    }
    /**
     * @路由规则
     */
    public function rules()
    {
        return [
            ['id','integer'],
            ['name', 'string', 'max' => 20],
            ['image','string', 'max' => 255],
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
            'status' => Yii::t('app', 'Status'),
        ];
    }

}
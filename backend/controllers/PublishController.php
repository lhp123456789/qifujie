<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace backend\controllers;

use backend\actions\ViewAction;
use common\models\Publish;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use common\models\Category;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use yii\helpers\ArrayHelper;

class PublishController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                         $data = Publish::find()->select(['c3.id','u.username','company_name','company_alias','logo','web_url', 'company_personner','company_phone','c2.parent_id','company_product','company_describe', 'c3.click','c3.unique','c3.status',
                                'c3.created_at','c3.updated_at','c2.name type_name','c3.error_result','c22.name p_type_name'])
                                ->from('{{%company}} c1')
                                ->leftJoin(['{{%comp_add}} c3'],'c3.comp_id=c1.id')
                                ->leftJoin(['{{%category}} c2'],'c2.id=c3.cid')
                                ->leftJoin(['{{%category}} c22'],'c22.id=c3.p_cid')
                                ->leftJoin(['{{%user}} u'],'u.id=c1.uid');
//                                ->where(['c3.status'=>1]);
//            var_dump($data->asArray()->all());exit();
                    $dataProvider = Yii::createObject([
                        'class' => ActiveDataProvider::className(),
                        'query' => $data,
                        'pagination' => [
                            'pageSize' => 10
                        ]
                    ]);
                    return [
                        'dataProvider' => $dataProvider,
                    ];
                }
            ],
            'view-layer' => [
                'class' => ViewAction::className(),
                'modelClass' => Publish::className(),

            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Publish::className(),
                'scenario' => 'default',
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Publish::className(),
                'scenario' => 'default',
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Publish::className(),
            ],
        ];
    }
}
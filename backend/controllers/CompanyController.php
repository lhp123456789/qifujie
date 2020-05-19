<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-23 15:13
 */

namespace backend\controllers;

use backend\models\form\NavigationForm;
use Yii;
use backend\models\Company;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\ViewAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class CompanyController extends \yii\web\Controller
{

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    $data = Company::find();
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
                'modelClass' => Company::className(),

            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Company::className(),
                'scenario' => 'company',
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Company::className(),
                'scenario' => 'company',
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Company::className(),
            ],

        ];
    }

}
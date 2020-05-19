<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-08-30 18:10
 */
namespace wechat\controllers;

use wechat\models\Category;
use wechat\models\Navigationbar;
use frontend\controllers\SearchController;
use Yii;
use wechat\models\form\SignupForm;
use common\models\User;
use wechat\models\form\LoginForm;
use yii\web\HttpException;
use yii\web\IdentityInterface;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use wechat\models\CompanyModel;
class SiteController extends PublicController
{
    public $modelClass = "wechat\models\Article";

    /**
     * 登录
     *
     * POST /login
     * {"username":"xxx", "password":"xxxxxx"}
     *
     * @return array
     */
    public function actionLogin()
    {
        $loginForm = new LoginForm();
        $loginForm -> setAttributes( Yii::$app -> getRequest() -> post() );
        if ($user = $loginForm -> login()) {
            $company=new CompanyModel();
            $company_detail=$company->CompanyDetail(['c1.uid'=>$user->id]);
            $datas = [
                	'userid' => $user->id,
                	'username' => $user->username,
                    'accessToken' => $user -> access_token,
                    'mobile' =>$user->mobile,
                
                    'expiredAt' => Yii::$app->params['user.wechatTokenExpire'] + time()
                ];
            if($company_detail){
                $datas['is_company_detail']=1;//有企业信息
                $datas['company_id']=$company_detail['company_id'];//企业id
                $datas['company_status']=$company_detail['company_status'];//企业状态
                $datas['company_phone'] =$company_detail['company_phone'];
            }else{
                $datas['is_company_detail']=0;//没有企业信息
            }
             $this->_response($datas,200);
        } else {
             $this->_response([],10009);
        }

    }
    /**
     * 注册
     *
     * POST /register
     * {"username":"xxx", "password":"xxxxxxx", "repwd":"xxxxxx"}
     *
     * @return array
     */
    public function actionRegister()
    {
        $signupForm = new SignupForm();
        $signupForm->setAttributes( Yii::$app->getRequest()->post() );
        if( ($user = $signupForm->signup()) instanceof User){
            $data = [
                "username" => $user -> username,
                "password" => $user -> password,
                "repwd" => $user -> repassword,
                "mobile" => $user -> mobile
            ];
           $this->_response($data,200);
        }else{
            $this->_response([],10010);
        }
    }
//    主页
    public function actionIndex()
    {
        //主体内容遍历
        $path = Category::find()->select(['id','name'])->where(['parent_id'=> 0])
                        ->orderBy('created_at asc')
                        ->asArray()
                        ->all();
        foreach ($path as $k=>$v)
        {
            $path[$k]['child'] = Category::find()
                ->select(['id','name'])
                ->where(['like', 'path', $v['id'].",%",false])
                ->andWhere(['<>','parent_id',0])
                ->andWhere(['status'=>1])
                ->orderBy('sort desc')
                ->asArray()
                ->all();
        }
        $this->_response($path,200);
    }
}

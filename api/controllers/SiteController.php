<?php
namespace api\controllers;

use api\models\Category;
use common\models\Article;
use Yii;
use api\models\form\SignupForm;
use common\models\User;
use api\models\form\LoginForm;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use api\models\CompanyModel;
class SiteController extends PublicController
{
    public $modelClass = "api\models\Article";

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        //默认浏览器打开返回json
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actions()
    {
        return [];
    }

    public function verbs()
    {
        return [
            'login' => ['POST'],
            'register' => ['POST'],
            'index' => ['GET', 'HEAD'],
        ];
    }

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
                
                    'expiredAt' => Yii::$app->params['user.apiTokenExpire'] + time()
                ];
            if($company_detail){
                $datas['is_company_detail']=1;//有企业信息
                $datas['company_id']=$company_detail['company_id'];//企业id
                $datas['company_status']=$company_detail['company_status'];//企业状态
                $datas['company_phone'] =$company_detail['company_phone'];
            }else{
                $datas['is_company_detail']=0;//没有企业信息
            }
                $data=[
                    'data'=>  $datas,
                    'code'=>200,
                    'msg'=>'成功'
                ];
                return $data;
        } else {
//            $data = ['error'=>$loginForm->firstErrors];
            $data=[
                'data'=>'',
                'code'=>422,
                'msg'=>'用户名或密码不正确'
            ];
            return $data;
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
            $data=[
                'data'=>  $data,
                'code'=>200,
                'msg'=>'成功'
            ];
            return $data;
        }else{
//            $data = ["error" => $signupForm ->firstErrors];
            $data=[
                'data'=>'',
                'code'=>422,
                'msg'=>'该用户名已被注册'
            ];
            return $data;
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
//        var_dump($path);exit();
        foreach ($path as $k=>$v) {
//            var_dump($v['path']);exit();
            $path[$k]['child'] = Category::find()->select(['id','name'])
                                        ->where(['like', 'path', $v['id'].",%",false])
                                        ->andWhere(['<>','parent_id',0])
                                        ->andWhere(['status'=>1])
                                        ->orderBy('sort desc')
                                        ->asArray()
                                        ->all();
        }

        $data=[
          'data'=>  $path,
            'code'=>200,
            'msg'=>'成功'
        ];
        return $data;


    }

}

<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-08-30 18:10
 */
namespace api\controllers;
use Yii;
use yii\web\Response;

class PublicController extends \yii\rest\ActiveController
{
//默认返回json
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
    //接收前端json
    function get_json()
    {
//        http://www.qd.com/api
        $json_str = file_get_contents("php://input");
        $result = json_decode($json_str, true);
//        var_dump($result);exit();
        return $result;
    }

    public function result($data = [], $code = 0, $msg = '', $option = JSON_UNESCAPED_UNICODE)
    {
        $result = array(
            'data' => $data,
            'code' => $code,
            'msg' => $msg ? $msg : Yii::$app->params[$code]
        );
        //print_r(json_encode($result, $option));exit();
        return json_encode($result, $option);
    }

    //检验是否为空
    public function verifyEmpty($result = [], $key = '', $default = '')
    {
        if (!empty($result[$key])) {
            if (is_array($result[$key])) {
                return $result[$key];
            }
            return trim($result[$key]);
        }
        return $default;
    }
    //检验是否传递参数
    function verifyIsset($result = [], $key = '')
    {
        $data = isset($result[$key]) ? trim($result[$key]) : '';
        return $data;
    }

    /**
     * @Notes:验证post请求
     * @return bool|mixed
     * @User:LHP
     * @Time: 2020/4/29
     */
    protected function is_post()
    {
        return Yii::$app->request->isPost;
    }

    /**
     * Notes:验证get请求
     * @return bool|mixed
     * @User:LHP
     * @Time: 2020/4/29
     */
    protected function is_get()
    {
        return Yii::$app->request->isGet;
    }
    /**
     * Notes:随机生成唯一的编号
     * @return bool|mixed
     * @User:LHP
     * @Time: 2020/4/29
     */
    protected function nonceStr()
    {
        static $seed = array(0,1,2,3,4,5,6,7,8,9);
        $str = date('mds');
        for($i=0;$i<8;$i++) {
            $rand = rand(0,count($seed)-1);
            $temp = $seed[$rand];
            $str .= $temp;
            unset($seed[$rand]);
            $seed = array_values($seed);
        }
        return $str;
    }
}

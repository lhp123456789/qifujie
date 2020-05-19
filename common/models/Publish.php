<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace common\models;

use backend\models\Company;
use Yii;
use common\helpers\FamilyTree;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class Publish extends \yii\db\ActiveRecord
{
    const CUSTOM_AUTOLOAD_NO = 0;
    const CUSTOM_AUTOLOAD_YES = 1;
    public static $thumbSizes = [
        ["w"=>168, "h"=>112]
    ];
    public $info;
    public $image;
    public $uid;
    public $cid;
    public $p_cid;
    public $username;
    public $company_name;
    public $company_alias;
    public $logo;
    public $parent_id;
    public $web_url;
    public $company_url;
    public $company_personner;
    public $company_phone;
    public $company_product;
    public $company_describe;
    public $unique;
    public $status;
    public $click;
    public $sort;
    public $name;
    public $type_name;
    public $p_type_name;
    public $alias;
    public $path;

    /**
     * @表名
     */
    public static function tableName()
    {
        return '{{%comp_add}}';
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
            [['sort', 'parent_id', 'created_at', 'updated_at','status','click'], 'integer'],
            [['sort'], 'compare', 'compareValue' => 0, 'operator' => '>='],
            [['parent_id'], 'default', 'value' => 0],
            [['name', 'alias','error_result'], 'string', 'max' => 255],
            [['image','company_name','company_alias'], 'string'],
            [['id','p_cid', 'cid'], 'integer'],
            [['unique'],'string'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, webp']
        ];
    }
    public function scenarios()
    {
        //这个方法表示需要表示哪些字段验证，比如user model，在注册时候，username是必填，
        return [
            'default' => [
                'id',
                'uid',
                'p_cid',
                'cid',
                'company_name',
                'company_alias',
                'company_url',
                'company_personner',
                'company_phone',
                'cusc',
                'id_number',
                'created_at',
                'updated_at',
                'click',
                'unique',
                'company_product',
                'company_describe',
                'status',
                'images',
                'error_result',
                'status',
//                'template'

            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_name' => Yii::t('app', 'Company Name'),
            'company_alias' => Yii::t('app', 'Company Alias'),
            'logo' => Yii::t('app', 'Logo'),
            'company_url' => Yii::t('app', 'Company Url'),
            'company_personner' => Yii::t('app', 'Company Personnner'),
            'company_phone' => Yii::t('app', 'Company Phone'),
            'company_product' => Yii::t('app', 'Company Product'),
            'company_describe' => Yii::t('app', 'Company Describe'),
            'click' => Yii::t('app', 'Company Describe'),
            'unique' => Yii::t('app', 'Company Describe'),
            'parent_id' => Yii::t('app', 'Parent Category Id'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }








    /*获取分类父级列表*/
    public function getPcate(){
        return $this->hasOne(Category::className(), ['parent_id' => 'p_cid']);
    }
    /*获取分类子集列表*/
    public function getCate()
    {
        return $this->hasOne(Category::className(), ['id' => 'cid']);
    }
    /*获取公司*/
    public function getComp(){
        return $this->hasOne(Company::className(),['id'=>'comp_id']);
    }




    /*获取父级类别名字*/
    protected static function _getP_Categories()
    {
        return \common\models\Category::find()
            ->select(['id','parent_id','name'])
            ->where(['parent_id'=>0])->asArray()->all();
    }
    public static function getP_Categories()
    {
        $categories = self::_getP_Categories();
//        var_dump($categories);exit();
        $data = [];
        foreach ($categories as $k=>$cates){
            $data[$cates['id']] = $cates['name'];
        }
        return $data;
    }

    /*获取子级类别名字*/
    protected static function _getCategories()
    {
        return \common\models\Category::find()->select(['id','name'])
            ->orderBy("path asc")->asArray()->all();
    }
    public static function getCategories()
    {
        $arr = \common\models\Category::find()->select(['id','name','path'])
            ->orderBy("path asc")->asArray()->all();
        $data = [];
        foreach ($arr as $val){
            $data[$val['id']] = str_repeat("&emsp;&emsp;",count(explode(',',$val['path'])) - 1).$val['name'];
        }

        return $data;
    }


    /*获取公司名字*/
    protected static function _getCompany(){
        return \backend\models\Company::find()->select(['id','company_name'])
            ->orderBy("id asc")->asArray()->all();
    }
    public static function getCompanyName(){
        $companys = self::_getCompany();
        $data = [];
        foreach ($companys as $k=>$compname){
            $data[$compname['id']] = $compname['company_name'];
        }
//        if(!$companys){
//            echo "<option value='" . 0 . "'>"  . "</option>";
//        }
//        foreach ($companys as $department) {
//            echo "<option value='" . $department['id'] . "'>" . $department['company_name'] . "</option>";
//        }
//        var_dump($data);exit();
        return $data;
    }


    /*获取公司链接*/
    protected static function _getCompanyUrl(){
        return \common\models\Publish::find()->select(['id','web_url'])
            ->orderBy("id asc")
            ->asArray()->all();
    }
    public static function getCompanyUrl(){
        $companys = self::_getCompanyUrl();
        $data = [];
        foreach ($companys as $k=>$compname){
            $data[$compname['id']] = $compname['web_url'];
        }
        return $data;
    }


    public function beforeSave($insert)
    {
        if( $insert ) {
            $this->id = null;
        }
        $this->setAttribute("comp_id", $this->comp_id);
        $this->setAttribute("p_cid", $this->p_cid);
        $this->setAttribute("cid", $this->cid);
        $this->setAttribute("status", $this->status);
        $this->setAttribute('unique',$this->unique);
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }


    public function afterFind()
    {
        $this->comp_id = $this->getAttribute("comp_id");//var_dump($this->comp_id);exit();
        $this->p_cid = $this->getAttribute("p_cid");//var_dump($this->p_cid);exit();
        $this->cid = $this->getAttribute("cid");
        $this->unique = $this->getAttribute("unique");

        $this->info = Publish::find()
            ->select(['c3.id','u.id','u.username','company_name','company_alias','logo','web_url',
                'company_personner','company_phone', 'c2.parent_id','company_product','company_describe',
                'c3.click','c3.unique','c3.status', 'c3.created_at','c3.cid','c3.p_cid','c3.updated_at',
                'c2.name type_name','c3.error_result','c22.name p_type_name'])
            ->from('{{%company}} c1')
            ->leftJoin(['{{%comp_add}} c3'],'c3.comp_id=c1.id')
            ->leftJoin(['{{%category}} c2'],'c2.id=c3.cid')
            ->leftJoin(['{{%category}} c22'],'c22.id=c3.p_cid')
            ->leftJoin(['{{%user}} u'],'u.id=c1.uid')
            ->where(['c3.status'=>1]);
        parent::afterFind();
    }
}

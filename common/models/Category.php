<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace common\models;

use common\helpers\FileDependencyHelper;
use common\helpers\Util;
use common\libs\Constants;
use feehi\cdn\TargetAbstract;
use Yii;
use common\helpers\FamilyTree;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $alias
 * @property integer $sort
 * @property string $template
 * @property string $article_category-template
 * @property string $remark
 * @property string $created_at
 * @property string $updated_at
 */
class Category extends \yii\db\ActiveRecord
{
    const CUSTOM_AUTOLOAD_NO = 0;
    const CUSTOM_AUTOLOAD_YES = 1;
    public static $thumbSizes = [
        ["w"=>168, "h"=>112]
    ];
    public $image;
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
            [['sort', 'parent_id', 'created_at', 'updated_at','status',"location"], 'integer'],
            [['sort'], 'compare', 'compareValue' => 0, 'operator' => '>='],
            [['parent_id'], 'default', 'value' => 0],
            [['name', 'alias'], 'string', 'max' => 255],
            [['name',], 'required'],
            [['image'], 'string'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, webp']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent Category Id'),
            'name' => Yii::t('app', 'Name'),
            'alias' => Yii::t('app', 'Alias'),
            'image' => Yii::t('app', 'Images'),
            'path' => Yii::t('app', 'Path'),
            'location' => Yii::t('app','Location'),
            'status' => Yii::t('app', 'Status'),
            'sort' => Yii::t('app', 'Sort'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }


    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    protected static function _getCategories()
    {
        return self::find()->orderBy("parent_id asc")->asArray()->all();
    }

    /**
     * @获取分类列表
     */
    public static function getCategories()
    {
        $categories = self::_getCategories();
        $familyTree = new FamilyTree($categories);
        $array = $familyTree -> getDescendants(0);
        return ArrayHelper::index($array, 'id');
    }

    /**
     * @ ├ '+' 分类名
     */
    public static function getCategoriesName()
    {
        $categories = self::getCategories();
        $data = [];
        foreach ($categories as $k => $category){
            if( isset($categories[$k+1]['level']) && $categories[$k+1]['level'] == $category['level'] ){
                $name = ' ├' . $category['name'];

            }else{
                $name = ' └' . $category['name'];
            }
            if( end($categories) == $category ){
                $sign = ' └';
            }else{
                $sign = ' │';
            }
            $data[$category['id']] = str_repeat($sign, $category['level']-1) . $name;
        }
        return $data;
    }

    /**
     * @ 递归
     */
    public function recursion($arr, $id)
    {
        $list = array();
        foreach ($arr as $k => $v) {
            if ($v['parent_id'] == $id) {
                $child = $this->recursion($arr, $v['id']);
                if (!empty($child)) {
                    $v['child'] = $child;
                }
                $list[] = $v;
            }
        }
        return $list;
    }

    /**
     * @获取菜单列表
     */
    public static function getMenuCategories($menuCategoryChosen=false)
    {
        $categories = self::getCategories();
        $familyTree = new FamilyTree($categories);
        $data = [];
        foreach ($categories as $k => $category){
            $parents = $familyTree->getAncectors($category['id']);
            $url = '';
            if(!empty($parents)){
                $parents = array_reverse($parents);
                foreach ($parents as $parent) {
                    $url .= '/' . $parent['alias'];
                }
            }
            if( isset($categories[$k+1]['level']) && $categories[$k+1]['level'] == $category['level'] ){
                $name = ' ├' . $category['name'];
            }else{
                $name = ' └' . $category['name'];
            }
            if( end($categories) == $category ){
                $sign = ' └';
            }else{
                $sign = ' │';
            }
            if( $menuCategoryChosen ){
                $url = '{"0":"article/index","cat":"' . $category['alias'] . '"}';
            }else{
                $url = '/'.$category['alias'];
            }
            $data[$url] = str_repeat($sign, $category['level']-1) . $name;
        }
        return $data;
    }

    /**
     * @param $id
     * @获取子分类列表
     */
    public static function getDescendants($id)
    {
        $familyTree = new FamilyTree(self::_getCategories());

        return $familyTree->getDescendants($id);
    }

    /**
     * @删除前判断是否有下级分类
     */
    public function beforeDelete()
    {
        $categories = self::find()->orderBy("sort asc,parent_id asc")->asArray()->all();
        $familyTree = new FamilyTree( $categories );
        $subs = $familyTree->getDescendants($this->id);
        if (! empty($subs)) {
            $this->addError('id', Yii::t('app', 'Allowed not to be deleted, sub level exsited.'));
            return false;
        }
        return parent::beforeDelete();
    }

    public function beforeSave($insert)
    {
        Util::handleModelSingleFileUploadAbnormal($this, 'image', '@uploads/category/images/', $this->getOldAttribute('image'), ['deleteOldFile'=>true]);
        $this->setAttribute("image", $this->image);
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
//        var_dump($this->image);exit();
        $this->image = $this->getAttribute("image");
        if ($this->image) {
            /** @var TargetAbstract $cdn */
            $cdn = Yii::$app->get('cdn');
            $this->image = $cdn->getCdnUrl($this->image);
        }
        parent::afterFind();
    }

    public function getThumbUrlBySize($width='', $height='')
    {
        if( empty($width) || empty($height) ){
            return $this->image;
        }
        if( empty($this->image) ){//未配图
            return $this->image = '/images/' . rand(1, 10) . '.jpg';
        }
        static $str = null;
        if( $str === null ) {
            $str = "";
            foreach (self::$thumbSizes as $temp){
                $str .= $temp['w'] . 'x' . $temp['h'] . '---';
            }
        }
        if( strpos($str, $width . 'x' . $height) !== false ){
            $dotPosition = strrpos($this->image, '.');
            $thumbExt = "@" . $width . 'x' . $height;
            if( $dotPosition === false ){
                return $this->image . $thumbExt;
            }else{
                return substr_replace($this->image,$thumbExt, $dotPosition, 0);
            }
        }
        return Yii::$app->getRequest()->getBaseUrl() . '/timthumb.php?' . http_build_query(['src'=>$this->image, 'h'=>$height, 'w'=>$width, 'zc'=>0]);
    }

    /**
     * @验证是否属于该父分类
     */
    public function afterValidate()
    {
        if (! $this->getIsNewRecord() ) {
            if( $this->id == $this->parent_id ) {
                $this->addError('parent_id', Yii::t('app', 'Cannot be themselves sub'));
                return false;
            }
            $familyTree = new FamilyTree(self::_getCategories());
            $descendants = $familyTree->getDescendants($this->id);
            $descendants = ArrayHelper::getColumn($descendants, 'id');
            if( in_array($this->parent_id, $descendants) ){
                $this->addError('parent_id', Yii::t('app', 'Cannot be themselves descendants sub'));
                return false;
            }
        }
        parent::afterValidate();
    }

    /**
     * @保存path
     */
    public function afterSave($insert, $changedAttributes)
    {
        self::_generateUrlRules();

        if($insert){
            $this->path = $this->parent_id . "," . $this->id;
            $this->save(false);
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    private static function _generateUrlRules()
    {
        $categories = self::getCategories();
        $familyTree = new FamilyTree($categories);
        $data = [];
        foreach ($categories as $v){
            $parents = $familyTree->getAncectors($v['id']);
            $url = '';
            if(!empty($parents)){
                $parents = array_reverse($parents);
                foreach ($parents as $parent) {
                    $url .= '/' . $parent['alias'];
                }
            }
            $url .= '/<cat:' . $v['alias'] . '>';
            $data[$url] = 'article/index';
        }
        $json = json_encode($data);
        $path = Yii::getAlias('@frontend/runtime/cache/');
        if( !file_exists($path) ) FileHelper::createDirectory($path);
        file_put_contents($path . 'category.txt', $json);
    }

    public static function getUrlRules()
    {
        $file = Yii::getAlias('@frontend/runtime/cache/category.txt');
        if( !file_exists($file) ){
            self::_generateUrlRules();
        }
        return json_decode(file_get_contents($file), true);
    }

    //获取其上级分类
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

}

<?php
namespace wechat\models;

use yii\base\Model;

class PublicModel extends \yii\db\ActiveRecord
{
    /**
     * @表名
     */
    protected $CATEGORY_TABLE='qd_category';//业务分类表
    protected $NAVIGATION_TABLE='qd_navigationbar';//导航表
    protected $COMPANY_TABLE='qd_company';//公司表
    protected $OPTIONS_TABLE='qd_options';//系统管理表
    protected $TERRITORY_TABLE='qd_territory';//地域表
    protected $COMP_ADD_TABLE='qd_comp_add';//企业类别关联表
    protected $USER_TABLE='qd_user';//用户表
    protected $WECHAT_USER_TABLE='qd_wechat_user';//用户表
//分页
    protected $defaultPage=1;
    protected $defaultPageSize=15;

//递归
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

}

<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2019-08-02 00:25
 */

namespace api\tests\unit\models;

use api\models\GoodsModel;

class ArticleCestTest extends \Codeception\Test\Unit
{
    public function testFields()
    {
        $model = new GoodsModel();
        expect("api article model fields should have title", $model->fields())->contains("title");
    }
}
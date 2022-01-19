<?php
namespace backend\widgets\common;

use yii\base\Widget;

class BlockDataWidget extends Widget
{
    public $params;

    public function run()
    {
        return $this->render('BlockDataWidget/index', ['params' => $this->params]);
    }

}

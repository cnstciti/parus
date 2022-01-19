<?php
namespace backend\widgets\client_rent;

use yii\base\Widget;

class ObjectsWidget extends Widget
{
    public $params;

    public function run()
    {
        return $this->render('ObjectsWidget/index', ['params' => $this->params]);
    }

}

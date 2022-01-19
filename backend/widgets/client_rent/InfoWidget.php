<?php
namespace backend\widgets\client_rent;

use yii\base\Widget;

class InfoWidget extends Widget
{
    public $params;

    public function run()
    {
        return $this->render('InfoWidget/index', ['params' => $this->params]);
    }

}

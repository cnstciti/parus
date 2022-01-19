<?php
namespace common\models;

use Yii;

class Params
{
    public static function parserApi() : string
    {
        return Yii::$app->params['parserApi'];
    }

}

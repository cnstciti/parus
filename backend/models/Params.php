<?php
namespace backend\models;

use Yii;

class Params
{
    public static function mapStrReplace() : string
    {
        return Yii::$app->params['mapStrReplace'];
    }

}

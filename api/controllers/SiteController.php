<?php

namespace api\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use common\models\Parser;
use api\models\SignupForm;
use yii\helpers\Url;
use api\models\auth\Role;
use api\models\rep\UserRep;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function actionIndex()
    {
        $e=0;
        return 'index';
    }

    public function actionQwe()
    {
        $e=0;
        return 'test';
    }

}

<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use common\models\Parser;
use backend\models\SignupForm;
use yii\helpers\Url;
use backend\models\auth\Role;
use backend\models\rep\UserRep;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            /*
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            */
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }

    public function actionIndexLk()
    {
        //$data = Parser::countRentObject();
        $userName = Yii::$app->user->identity->username;
        return $this->render('index_lk', [
            //'data' => $data,
            'userName' => $userName,
        ]);
    }

    public function actionLogin()
    {
        //$z=0;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //$e=0;
            //return $this->goHome();
            //return $this->goBack();
            $this->redirect(Url::to(['site/index-lk']));
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {

            $auth = Yii::$app->authManager;
            $roleRent = $auth->getRole(Role::RENT_NAME);
            $user = UserRep::findRowByUsername($model->username);
            $auth->assign($roleRent, $user['id']);

            Yii::$app->session->setFlash('success', 'Для завершения регистрации обратитесь к администратору системы.');
            return $this->goHome();
        }

        $this->layout = 'blank';

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

}

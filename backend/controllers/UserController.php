<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use common\models\Parser;
use backend\models\rep\UserRep;
use yii\data\ArrayDataProvider;
use yii\web\BadRequestHttpException;
use yii\helpers\Url;

/**
 * User controller
 */
class UserController extends Controller
{
    public function actionIndex()
    {
        $data = UserRep::getList();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 500,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionChangeStatus()
    {
        UserRep::changeStatus(self::getId());

        $this->redirect(Url::to(['user/index']));
    }

    /**
     * Возвращает ИД клиента из GET-параметра
     *
     * @return int
     * @throws BadRequestHttpException
     */
    protected static function getId(): int
    {
        $getId = Yii::$app->request->get('id', '');
        $id = (int)$getId;
        if ($getId != (string)$id) {
            throw new BadRequestHttpException('Ошибка параметра id');
        }

        return $id;
    }

}
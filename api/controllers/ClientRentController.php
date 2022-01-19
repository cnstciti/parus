<?php

namespace api\controllers;

use backend\models\ClientRent;
use yii\web\Controller;
use Yii;

/**
 * ClientRent controller
 */
class ClientRentController extends Controller
{
    /**
     * Добавление ОН для всех существующих клиентов
     *
     * Вызов:
     *      POST <SERVER>/client-rent/add-on
     *
     * Вход:
     *      'id' -> <int>   // ИД объекта недвижимости
     *
     * Выход:
     *      нет
     */
    public function actionAddOn()
    {
        $request = Yii::$app->getRequest();
        $params  = $request->isPost ? $request->getBodyParams() : [];

        ClientRent::addON($params['id']);
    }

    /**
     * Удаление ОН для всех существующих клиентов
     *
     * Вызов:
     *      POST <SERVER>/client-rent/delete-on
     *
     * Вход:
     *      'id' -> <int>   // ИД объекта недвижимости
     *
     * Выход:
     *      нет
     */
    public function actionDeleteOn()
    {
        $request = Yii::$app->getRequest();
        $params  = $request->isPost ? $request->getBodyParams() : [];

        ClientRent::deleteON($params['id']);
    }

}

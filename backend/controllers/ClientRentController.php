<?php
namespace backend\controllers;

use backend\models\ClientRent;
use backend\models\block\client_rent\Info;
use backend\models\block\client_rent\Objects;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Контроллер "Клиенты. Аренда"
 */
class ClientRentController extends Controller
{
    /**
     * Возвращает список клиентов текщуего пользователя
     *
     * @return string
     */
    public function actionIndex()
    {
        $data = ClientRent::getList(Yii::$app->user->identity->id);

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

    /**
     * Возвращает список клиентов Администратора
     *
     * @return string
     */
    public function actionIndexAdmin()
    {
        $data = ClientRent::getListAdmin();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 500,
            ],
        ]);

        return $this->render('index-admin', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Открывает карточку клиента
     *
     * @param int $id - ИД клиента
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionView()
    {
        $client = ClientRent::getById(self::getId());

        // можно смотреть Администратору и
        // защита от просмотра "чужих" клиентов
        // другими пользователями
        $userId = Yii::$app->user->identity->id;
        if ($userId != 1 && $client['user_id'] != $userId) {
            $this->redirect(Url::to(['client-rent/index']));
        }

        return $this->render('view', [
            'info'    => Info::show($client),
            'objects' => Objects::show($client),
            'client'  => $client,
        ]);
    }

    /**
     * Добавление нового клиента
     *
     * @return string
     */
    public function actionAdd()
    {
        $clientId = ClientRent::add(Yii::$app->user->identity->id);

        return $this->redirect(Url::to(['client-rent/view', 'id' => $clientId]));
    }

    /**
     * Редактирование информации о клиенте
     *
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionEditInfo()
    {
        $id = self::getId();
        $client = ClientRent::getInfo($id);

        if ($client->load(Yii::$app->request->post()) && $client->validate()) {
            ClientRent::saveInfo($client);
            return $this->redirect(Url::to(['client-rent/view', 'id' => $id]));
        }

        return $this->renderAjax('@backend/widgets/client_rent/views/InfoWidget/_modal', ['model' => $client, 'id' => $id]);
    }

    /**
     * Редактирование информации об объектах клиента
     *
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionEditObjects()
    {
        $id = self::getId();
        $client = ClientRent::getObjects($id);

        if ($client->load(Yii::$app->request->post()) && $client->validate()) {
            ClientRent::saveObjects($client);
            return $this->redirect(Url::to(['client-rent/view', 'id' => $id]));
        }

        return $this->renderAjax('@backend/widgets/client_rent/views/ObjectsWidget/_modal', ['model' => $client, 'id' => $id]);
    }

    /**
     * Сохранение данных с Яндекс-карты
     *
     */
    public function actionSave()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $params = [
                'polygons' => $request->post('polygons'),
                'zoom'     => $request->post('zoom'),
                'center'   => $request->post('center'),
                'clientId' => $request->post('clientId'),
            ];

            ClientRent::saveMapParams($params);

            return $this->redirect(Url::to(['client-rent/view', 'id' => $params['clientId']]));
        }

        return $this->redirect(Url::to(['client-rent/list']));
    }

    /**
     * Возвращает список объектов клиента
     *
     * @return string
     */
    public function actionMapObjects()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            //$clientId = intval($request->post('clientId'));
            return ClientRent::getMapObjects(intval($request->post('clientId')));
            /*
            $params = [
                'clientId' => $request->post('clientId'),
            ];

            return ClientRent::getMapObjects(intval($params['clientId']));
            */
        }

        return $this->redirect(Url::to(['client-rent/list']));
    }

    /**
     * Удаление клиента
     *
     * @return string
     */
    public function actionDelete()
    {
        $clientId = Yii::$app->request->get('id', '');

        ClientRent::delete($clientId);

        return $this->redirect(Url::to(['client-rent/list']));
    }

    /**
     * Кнопка "Не подходит"
     */
    public function actionNotSuitable()
    {
        $id = $this->getId();
        $clientId = Yii::$app->request->get('client', '');

        ClientRent::notSuitable($id, $clientId);
    }

    /**
     * Кнопка "Удалить"
     */
    public function actionDeleteObject()
    {
        $id = $this->getId();

        ClientRent::deleteObject($id);
    }

    /**
     * Кнопка "Недозвон"
     */
    public function actionNonCall()
    {
        $id = $this->getId();
        $clientId = Yii::$app->request->get('client', '');

        ClientRent::nonCall($id, $clientId);
    }

    /**
     * Возвращает ИД клиента из GET-параметра
     *
     * @return int
     * @throws BadRequestHttpException
     */
    protected static function getId() : int
    {
        $getId = Yii::$app->request->get('id', '');
        $id = (int)$getId;
        if ($getId != (string)$id) {
            throw new BadRequestHttpException('Ошибка параметра id');
        }

        return $id;
    }

}

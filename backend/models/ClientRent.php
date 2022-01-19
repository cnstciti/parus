<?php
namespace backend\models;

use backend\models\form\client_rent\InfoForm;
use backend\models\form\client_rent\ObjectsForm;
use backend\models\map\MapClientRent;
use backend\models\rep\ClientRentRep;
//use common\models\rep\MyObjectRep;
use backend\models\rep\ClientRentObjectsRep;
use Yii;
//use yii\db\ActiveRecord;
use common\models\Parser;

class ClientRent
{
    public static function delete(int $clientId)
    {
        ClientRentObjectsRep::delete($clientId);
        ClientRentRep::delete($clientId);
    }

    public static function add(int $userId)
    {
        $id      = ClientRentRep::insertNew($userId);
        $objects = Parser::listIdsRentObject();
        $data    = [];
        if (!$objects['error']['code'] && is_array($objects['result'])) {
            foreach ($objects['result'] as $object) {
                $data[] = [
                    'id_client' => $id,
                    'id_object' => $object['id'],
                ];
            }
        }
        ClientRentObjectsRep::batchInsert($data);

        return $id;
    }

    public static function getList(int $userId) : array
    {
        return ClientRentRep::getList($userId);
    }

    public static function getListAdmin() : array
    {
        return ClientRentRep::getListAdmin();
    }

    public static function getById(int $id)
    {
        $client = ClientRentRep::getById($id);
        if (isset($client['search_date'])) {
            $client['search_date'] = Yii::$app->formatter->asDate($client['search_date'], 'dd.MM.yyyy');
        }

        return $client;
    }

    public static function getInfo(int $id)
    {
        $client = InfoForm::findOne($id);
        if (isset($client['search_date'])) {
            $client['search_date'] = Yii::$app->formatter->asDate($client['search_date'], 'dd.MM.yyyy');
        }

        return $client;
    }

    public static function saveInfo($client) : void
    {
        $client['search_date'] = Yii::$app->formatter->asDate($client['search_date'], 'yyyy-MM-dd');
        $client->save();
    }

    public static function getObjects(int $id)
    {
        $client = ObjectsForm::findOne($id);

        return $client;
    }

    public static function saveObjects($client) : void
    {
        $client->save();
    }

    public static function saveMapParams(array $params) : void
    {
        $polygons = trim($params['polygons'], '#');
        $zoom     = intval($params['zoom']);
        $center   = $params['center'];
        $center   = '[' . $center[0] . ',' . $center[1] . ']';
        $clientId = intval($params['clientId']);

        ClientRentRep::saveMap($clientId, $polygons, $zoom, $center);
    }

    public static function getMapObjects(int $clientId) : string
    {
        //$clientId = intval($params['clientId']);
        //return (new MapClientRent)->create($clientId);
        return MapClientRent::create($clientId);
    }

    public static function addON(int $onId) : void
    {
        $clients = self::getListAdmin();

        $tmp = [];
        foreach ($clients as $client) {
            $tmp[] = [
                'id_client' => $client['id'],
                'id_object' => $onId,
            ];
        }

        ClientRentObjectsRep::batchInsert($tmp);
    }

    public static function notSuitable(int $onId, int $clientId) : void
    {
        ClientRentObjectsRep::setStatusByClient($onId, $clientId, ClientRentObjectsRep::STATUS_NOT_SUITABLE);
    }

    public static function deleteObject(int $onId) : void
    {
        ClientRentObjectsRep::setStatus($onId, ClientRentObjectsRep::STATUS_NOT_SUITABLE);
        Parser::deleteObject($onId);
    }

    public static function nonCall(int $onId, int $clientId) : void
    {
        ClientRentObjectsRep::setNonCall($onId, $clientId);
    }

}

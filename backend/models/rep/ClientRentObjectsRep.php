<?php
namespace backend\models\rep;

use Yii;
use backend\models\ar\ClientRentObjectAR;

/**
 *  Таблица "Список клиентов - аренда"
 *
 * @author Constantin Ogloblin <cnst@mail.ru>
 * @since 1.0.0
 */
class ClientRentObjectsRep
{
    const STATUS_SUITABLE = 'подходит';
    const STATUS_NOT_SUITABLE = 'не подходит';


    public static function batchInsert(array $data) : void
    {
        Yii::$app->db->createCommand()
            ->batchInsert(ClientRentObjectAR::tableName(), ['id_client', 'id_object'], $data)
            ->execute();
    }

    public static function findClientRent(array $objects, int $clientId) : array
    {
        /*
        $conditions = [
            'condition1' => '',
            'condition2' => '',
            'condition3' => '',
            'condition4' => '',
            'condition5' => '',
            'condition6' => '',
            'condition7' => '',
            'condition8' => '',
        ];
        if ($params['flat1']['is'] && $params['flat1']['amount']) {
            $conditions['condition1'] = "(obj.myTypeObject = 'квартира' and obj.myRooms='1' and obj.myPrice<=" . $params['flat1']['amount'] . " and cl_obj.status='подходит')";
        }
        if ($params['flat2']['is'] && $params['flat2']['amount']) {
            $conditions['condition2'] = "(obj.myTypeObject = 'квартира' and obj.myRooms='2' and obj.myPrice<=" . $params['flat2']['amount'] . ")";
        }
        if ($params['flat3']['is'] && $params['flat3']['amount']) {
            $conditions['condition3'] = "(obj.myTypeObject = 'квартира' and obj.myRooms='3' and obj.myPrice<=" . $params['flat3']['amount'] . ")";
        }
        if ($params['flat4']['is'] && $params['flat4']['amount']) {
            $conditions['condition4'] = "(obj.myTypeObject = 'квартира' and obj.myRooms='4' and obj.myPrice<=" . $params['flat4']['amount'] . ")";
        }
        if ($params['flat5']['is'] && $params['flat5']['amount']) {
            $conditions['condition5'] = "(obj.myTypeObject = 'квартира' and obj.myRooms='5' and obj.myPrice<=" . $params['flat5']['amount'] . ")";
        }
        if ($params['flat6']['is'] && $params['flat6']['amount']) {
            $conditions['condition6'] = "(obj.myTypeObject = 'квартира' and obj.myRooms='6' and obj.myPrice<=" . $params['flat6']['amount'] . ")";
        }
        if ($params['studio']['is'] && $params['studio']['amount']) {
            $conditions['condition7'] = "(obj.myTypeObject = 'квартира' and obj.myRooms='студия' and obj.myPrice<=" . $params['studio']['amount'] . ")";
        }
        if ($params['room']['is'] && $params['room']['amount']) {
            $conditions['condition8'] = "(obj.myTypeObject = 'комната' and obj.myPrice<=" . $params['room']['amount'] . ")";
        }

        $where = '';
        foreach ($conditions as $condition) {
            if ($condition) {
                if ($where) {
                    $where .= ' or ' . $condition;
                } else {
                    $where .= $condition;
                }
            }
        }
        if ($where) {
            $where = ' and (' . $where . ')';
        }
        $query = "
            select
                obj.*
            from
                client_rent_object cl_obj
            left JOIN 
                my_object obj
                on cl_obj.id_object=obj.id
            where 
                obj.status = 'загружен'
                and obj.myActionObject = 'аренда'

                and cl_obj.id_client=" . $clientId . "
                and cl_obj.status='подходит'
        " . $where;
        return Yii::$app->db->createCommand($query)->queryAll();
        */
        //$ids = implode(',', array_column($objects, 'id'));
        $clientObjects = ClientRentObjectAR::find()
            ->where('id_object in(' . implode(',', array_column($objects, 'id')) . ')')
            ->andWhere([
                'id_client' => $clientId,
                'status'    => self::STATUS_SUITABLE,
            ])
            ->asArray()
            ->all();
        $ret = [];
        foreach ($objects as $object) {
            foreach ($clientObjects as $client) {
                if ($object['id'] == $client['id_object']) {
                    $object['non_call'] = $client['non_call'];
                    $ret[] = $object;
                }
            }
        }

        return $ret;
    }

    public static function setStatus(int $objectId, string $status) : void
    {
        $query = "
            update
                client_rent_object
            set
                status='" . $status . "'
            where 
                id_object=" . $objectId . "
        ";
        Yii::$app->db->createCommand($query)->execute();
    }

    public static function setStatusByClient(int $objectId, int $clientId, string $status) : void
    {
        $query = "
            update
                client_rent_object
            set
                status='" . $status . "'
            where 
                id_object=" . $objectId . "
                and id_client=" . $clientId . "
        ";
        Yii::$app->db->createCommand($query)->execute();
    }

    public static function delete(int $clientId) : void
    {
        ClientRentObjectAR::deleteAll(['id_client' => $clientId]);
    }

    public static function setNonCall(int $objectId, int $clientId) : void
    {
        $query = "
            update
                client_rent_object
            set
                non_call=1
            where 
                id_object=" . $objectId . "
                and id_client=" . $clientId . "
        ";
        Yii::$app->db->createCommand($query)->execute();
    }

}

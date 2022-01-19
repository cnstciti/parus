<?php
namespace backend\models\rep;

use Yii;
use backend\models\ar\ClientRentAR;

/**
 *  Таблица "Список клиентов - аренда"
 *
 * @author Constantin Ogloblin <cnst@mail.ru>
 * @since 1.0.0
 */
class ClientRentRep
{
    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getList(int $userId) : array
    {
        return ClientRentAR::find()
            ->where(['user_id' => $userId])
            ->asArray()
            ->all();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getListAdmin() : array
    {
        $query = "
            select
                c.*, u.username
            from
                client_rent c
            left JOIN user u
                on c.user_id=u.id
        ";
        return Yii::$app->db->createCommand($query)->queryAll();
/*
        return ClientRentAR::find()
            ->asArray()
            ->all();
*/
    }

    public static function getById(int $id)// : array
    {
        //return ClientRentAR::findOne($id);
        return ClientRentAR::find()
            ->where(['id' => $id])
            //->asArray()  // здесь массивов не должно быть!
            ->one();
    }

    public static function saveMap(
        int $id,
        string $polygons,
        int $zoom,
        string $center
    ) : void
    {
        $row           = self::getById($id);
        $row->polygons = $polygons;
        $row->zoom     = $zoom;
        $row->center   = $center;
        $row->save();
    }

    public static function insertNew(int $userId) : int
    {
        $row          = new ClientRentAR;
        $row->user_id = $userId;
        $row->save();

        return Yii::$app->db->getLastInsertID();
    }

    public static function delete(int $id) : void
    {
        $row = ClientRentAR::findOne($id);
        $row->delete();
    }
}
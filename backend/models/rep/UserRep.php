<?php
namespace backend\models\rep;

use Yii;
use common\models\User;

/**
 *  Таблица ""
 *
 * @author Constantin Ogloblin <cnst@mail.ru>
 * @since 1.0.0
 */
class UserRep
{
    public static function getList() : array
    {
        return User::find()
            ->where(['<>', 'id', 1])
            ->asArray()
            ->all();
    }

    public static function changeStatus(int $id) : void
    {
        $row = User::findOne($id);
        if ($row->status == 10) {
            $row->status = 9;
        } else {
            $row->status = 10;
        }
        $row->save();
    }

    public static function findRowByUsername(string $username)
    {
        return User::findOne(['username' => $username]);
    }

}
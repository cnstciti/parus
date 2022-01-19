<?php
namespace backend\models\ar;

use yii\db\ActiveRecord;

/**
 *  "Таблица "
 *
 * @author Constantin Ogloblin <cnst@mail.ru>
 * @since 1.0.0
 */
class ClientRentAR extends ActiveRecord
{

    /**
    * @return string название таблицы, сопоставленной с этим ActiveRecord-классом.
    */
    public static function tableName()
    {
        return '{{client_rent}}';
    }
}
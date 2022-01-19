<?php
namespace backend\models\block\client_rent;

use backend\models\block\BaseBlock;
use backend\widgets\client_rent\ObjectsWidget;
use yii\helpers\Url;

class Objects extends BaseBlock
{

    public static function show($client)
    {
        $idButton = 'objects-btn';
        $params = [
            'class'     => self::CLASS_SUCCESS,
            'header'    => [
                'class' => self::CLASS_HEADER_SUCCESS,
                'title'  => 'Объекты',
                'button' => [
                    'id'     => $idButton,
                    //'class'  => self::DEFAULT_CLASS_ICON,
                    //'icon'   => self::DEFAULT_ICON,
                    //'title'  => 'Редактировать Контактное лицо',
                    'action' => Url::to(['client-rent/edit-objects', 'id' => $client['id']]),
                ],
            ],
            'content'   => ObjectsWidget::widget([
                'params'    => [
                    'client'   => $client,
                    'idButton' => $idButton,
                ],
            ]),
        ];

        return parent::showBlock($params);
    }

}

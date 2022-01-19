<?php
namespace backend\models\block\client_rent;

use backend\models\block\BaseBlock;
use backend\widgets\client_rent\InfoWidget;
use yii\helpers\Url;

class Info extends BaseBlock
{

    public static function show($client)
    {
        $idButton = 'client-btn';
        $params = [
            'class'     => self::CLASS_SUCCESS,
            'header'    => [
                'class' => self::CLASS_HEADER_SUCCESS,
                'title'  => 'Общая информация',
                'button' => [
                    'id'     => $idButton,
                    //'class'  => self::DEFAULT_CLASS_ICON,
                    //'icon'   => self::DEFAULT_ICON,
                    //'title'  => 'Редактировать Контактное лицо',
                    'action' => Url::to(['client-rent/edit-info', 'id' => $client['id']]),
                ],
            ],
            'content'   => InfoWidget::widget([
                'params'    => [
                    'client'   => $client,
                    'idButton' => $idButton,
                ],
            ]),
        ];

        return parent::showBlock($params);
    }

}

<?php
namespace backend\models\form\client_rent;

use backend\models\ar\ClientRentAR;

/**
 *
 */
class ObjectsForm extends ClientRentAR
{

    public function rules()
    {
        return [
            ['flat1', 'safe'],
            ['amount_flat1', 'safe'],
            ['flat2', 'safe'],
            ['amount_flat2', 'safe'],
            ['flat3', 'safe'],
            ['amount_flat3', 'safe'],
            ['flat4', 'safe'],
            ['amount_flat4', 'safe'],
            ['flat5', 'safe'],
            ['amount_flat5', 'safe'],
            ['flat6', 'safe'],
            ['amount_flat6', 'safe'],
            ['studio', 'safe'],
            ['amount_studio', 'safe'],
            ['room', 'safe'],
            ['amount_room', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'flat1'         => '1-к. квартира',
            //'amount_flat1'  => 'бюджет ДО',
            'flat2'         => '2-к. квартира',
            //'amount_flat2'  => 'бюджет ДО',
            'flat3'         => '3-к. квартира',
            //'amount_flat3'  => 'бюджет ДО',
            'flat4'         => '4-к. квартира',
            //'amount_flat4'  => 'бюджет ДО',
            'flat5'         => '5-к. квартира',
            //'amount_flat5'  => 'бюджет ДО',
            'flat6'         => '6-к. квартира',
            //'amount_flat6'  => 'бюджет ДО',
            'studio'        => 'Студия',
            //'amount_studio' => 'бюджет ДО',
            'room'          => 'Комната',
            //'amount_room'   => 'бюджет ДО',

        ];
    }

}

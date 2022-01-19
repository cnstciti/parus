<?php
namespace backend\models\form\client_rent;

use backend\models\ar\ClientRentAR;

/**
 *
 */
class InfoForm extends ClientRentAR
{

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Введите имя клиента'],
            ['phone', 'required', 'message' => 'Введите телефон клиента'],
            ['adults', 'required', 'message' => 'Введите проживающих'],
            ['search_date', 'required', 'message' => 'Введите дату'],

            ['whats_app', 'safe'],
            ['telegram', 'safe'],
            ['children', 'safe'],
            ['animals', 'safe'],
            ['can_view', 'safe'],
            ['comment', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'        => 'Имя клиента',
            'phone'       => 'Телефон клиента',
            'adults'      => 'Взрослые',
            'search_date' => 'Поиск ДО даты',
            'whats_app'   => 'WhatsApp клиента',
            'telegram'    => 'Telegram клиента',
            'children'    => 'Дети',
            'animals'     => 'Наличие животных',
            'can_view'    => 'Могут просматривать',
            'comment'     => 'Комментарий',
        ];
    }

}

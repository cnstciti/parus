<?php
namespace common\models;

use GuzzleHttp\Client as HttpClient;
use yii\helpers\Json;

class Parser
{

    /**
     * Возвращает список ИД ОН аренды (квартиры + комнаты)
     *
     * Вход:
     *      Нет
     *
     * Выход: array
     *  [
     *      'error' => [
     *          'code'        => 0,
     *          'description' => '',
     *      ],
     *      'result' => [
     *          {
     *              'id' => <int> // ИД ОН аренды
     *          }
     *      ]
     *  ]
     */
    public static function listIdsRentObject() : array
    {
        $apiURL = Params::parserApi() . '/rent/list-ids-object';
        try {
            $response = (new HttpClient())->get($apiURL);
            $body = $response->getBody()->getContents();
            $body = [
                'error' => [
                    'code'        => 0,
                    'description' => '',
                ],
                'result' => Json::decode($body),
            ];
        } catch (\Exception $e) {
            $body = [
                'error' => [
                    'code'        => $e->getCode(),
                    'description' => $e->getMessage(),
                ]
            ];
        }

        return $body;
    }

    /**
     * Поиск ИД ОН аренды (квартиры + комнаты)
     *
     * Вход: array
     *  [
     *      'flat1Amount' => <int>,     // максимальная стоимость 1-ком. квартиры
     *      'flat2Amount' => <int>,     // максимальная стоимость 2-ком. квартиры
     *      'flat3Amount' => <int>,     // максимальная стоимость 3-ком. квартиры
     *      'flat4Amount' => <int>,     // максимальная стоимость 4-ком. квартиры
     *      'flat5Amount' => <int>,     // максимальная стоимость 5-ком. квартиры
     *      'flat6Amount' => <int>,     // максимальная стоимость 6-ком. квартиры
     *      'studioAmount' => <int>,     // максимальная стоимость квартиры-студии
     *      'roomAmount' => <int>,     // максимальная стоимость комнаты
     *  ]
     *  Не все ключи могут быть переданы
     *
     * Выход: array
     *  [
     *      'error' => [
     *          'code'        => 0,
     *          'description' => '',
     *      ],
     *      'result' => [
     *          {
     *              'id'          => <int>,     // ИД объекта
     *              'type_object' => <enum>,    // Тип объекта
     *              'rooms'       => <enum>,    // Количество комнат
     *              'latitude'    => <string>,  // Географическая широта
     *              'longitude'   => <string>,  // Географическая долгота
     *              'address'     => <string>,  // Адрес
     *              'price'       => <int>,     // Стоимость
     *              'url'         => <string>   // Ссылка на страницу
     *          }
     *      ]
     *  ]
     */
    public static function rentSearch(array $params) : array
    {
        $apiURL = Params::parserApi() . '/rent/search';
        try {
            $response = (new HttpClient())->post($apiURL, [
                    'form_params' => $params
                ]);
            $body = $response->getBody()->getContents();
            $body = [
                'error' => [
                    'code'        => 0,
                    'description' => '',
                ],
                'result' => Json::decode($body),
            ];
        } catch (\Exception $e) {
            $body = [
                'error' => [
                    'code'        => $e->getCode(),
                    'description' => $e->getMessage(),
                ]
            ];
        }

        return $body;
    }

    /**
     * Удаление ОН
     *
     * Вход:
     *      'id' => <int> // ИД ОН аренды
     *
     * Выход:
     *      нет
     */
    public static function deleteObject(int $id) : void
    {
        $apiURL = Params::parserApi() . '/on/delete';
        try {
            $params['id'] = $id;
            $response = (new HttpClient())->post($apiURL, [
                    'form_params' => $params
                ]);
            //$body = $response->getBody()->getContents();
            /*
            $body = [
                'error' => [
                    'code'        => 0,
                    'description' => '',
                ],
                'result' => Json::decode($body),
            ];
            */
        } catch (\Exception $e) {
            /*
            $body = [
                'error' => [
                    'code'        => $e->getCode(),
                    'description' => $e->getMessage(),
                ]
            ];
            */
        }

        //return $body;
    }

    /**
     * Возвращает количество ОН аренды (квартиры + комнаты)
     *
     * Выход: array
     *  [
     *      'flatPublished' => <int> -> количество опубликованных квартир аренды
     *      'flatLoaded'    => <int> -> количество загруженных квартир аренды
     *      'roomPublished' => <int> -> количество опубликованных комнат аренды
     *      'roomLoaded'    => <int> -> количество загруженных комнат аренды
     *  ]
     */
    public static function countRentObject() : array
    {
        $apiURL = Params::parserApi() . '/count-rent-object';
        try {
            $response = (new HttpClient())->get($apiURL);
            $body = $response->getBody()->getContents();
            $body = [
                'error' => [
                    'code'        => 0,
                    'description' => '',
                ],
                'result' => Json::decode($body),
            ];
        } catch (\Exception $e) {
            $body = [
                'error' => [
                    'code'        => $e->getCode(),
                    'description' => $e->getMessage(),
                ]
            ];
        }

        return $body;
    }

}

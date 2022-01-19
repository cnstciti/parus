<?php
namespace backend\models\map;

use backend\models\rep\ClientRentObjectsRep;
use backend\models\rep\ClientRentRep;
use common\models\Parser;
use backend\models\Params;
use yii\helpers\ArrayHelper;

class MapClientRent
{
    public static function create(int $clientId) : string
    {
        $client       = ClientRentRep::getById($clientId);
        $amountArray  = self::_prepareAmountArray($client);
        $polygonArray = self::_preparePolygonArray($client);
        $params       = ArrayHelper::merge($amountArray, $polygonArray);
        $objects      = Parser::rentSearch($params);
        /*
        if ($client['amount_flat1']) {
            $params['flat1Amount'] = $client['amount_flat1'];
        }
        if ($client['amount_flat2']) {
            $params['flat2Amount'] = $client['amount_flat2'];
        }
        if ($client['amount_flat3']) {
            $params['flat3Amount'] = $client['amount_flat3'];
        }
        if ($client['amount_flat4']) {
            $params['flat4Amount'] = $client['amount_flat4'];
        }
        if ($client['amount_flat5']) {
            $params['flat5Amount'] = $client['amount_flat5'];
        }
        if ($client['amount_flat6']) {
            $params['flat6Amount'] = $client['amount_flat6'];
        }
        if ($client['amount_studio']) {
            $params['studioAmount'] = $client['amount_studio'];
        }
        if ($client['amount_room']) {
            $params['roomAmount'] = $client['amount_room'];
        }
*/

        if (!$objects['error']['code'] && !empty($objects['result'])) {
            $objects = ClientRentObjectsRep::findClientRent($objects['result'], $clientId);
        }
/*
        $polygons = [];
        $polygonsClient = explode('#', $client['polygons']);
        foreach ($polygonsClient as $polygon) {
            if ($polygon && $polygon != '[[],[]]') {
                $s1 = str_replace(']],[]]', '', $polygon);
                $s1 = str_replace('[[[', '', $s1);
                $coors = explode('],[', $s1);
                $tmp = [];
                foreach ($coors as $coor) {
                    list($x, $y) = explode(',', $coor);
                    $tmp[] = [$x, $y];
                }
                $polygons[] = $tmp;
            }
        }
*/
        $json = '{
                "type": "FeatureCollection",
                    "features": [
            ';

        foreach ($objects as $object) {
            if ($object['latitude'] && $object['longitude']) {
                switch ($object['type_object']) {
                    case 'комната':
                        $room = 'Комната';
                        $iconContent = 'К';
                        $iconColor = 'islands#grayIcon';
                        break;
                    case 'квартира':
                        if ($object['rooms'] == 'студия') {
                            $room = 'Квартира-студия';
                            $iconContent = 'С';
                            $iconColor = 'islands#yellowIcon';
                        } else {
                            $room = $object['rooms'] . '-к квартира';
                            $iconContent = $object['rooms'];
                            switch ($object['rooms']) {
                                case 1: $iconColor = 'islands#blueIcon'; break;
                                case 2: $iconColor = 'islands#darkGreenIcon'; break;
                                case 3: $iconColor = 'islands#redIcon'; break;
                                case 4: $iconColor = 'islands#darkOrangeIcon'; break;
                                case 5: $iconColor = 'islands#violetIcon'; break;
                                case 6: $iconColor = 'islands#brownIcon'; break;
                            }
                        }
                        break;
                }
                if ($object['non_call'] == 1) {
                    $iconColor = 'islands#pinkDotIcon';
                }

                //$address = $object['address'] ? $object['myAddress'] : $object['address'];
                $address = $object['address'];
                $price = number_format($object['price'], 0, '.', ' ');
                $balloonContentHeader = '<div class=\'balloon-header\'>' . $room . '</div>';
//<p><a target=\'_blank\' href=\'' . Url::to(['not-parser-flat-rent/view', 'id' => $object['id'], 'client' => $clientId]) . '\'>' . $room . '</a></p>';
                $balloonContentBody   = '
                    <div class=\'balloon-body mb-1 mt-1\'>
                        <div class=\'row\'>
                            <div class=\'col-2 label mb-3\' style=\'padding-top:.6rem;\'>Цена:</div>
                            <div class=\'col-3 price mt-2\'>' . $price . '</div>
                            <div class=\'col-7 label mt-2\'>№ объекта: ' . $object['id'] . '</div>
                            <div class=\'col-12\'>
                                <div class=\'row\'>
                                    <div class=\'col-4\'><a class=\'btn btn-primary btn-sm w-100\' href=\'' . $object['url'] . '\' role=\'button\' target=\'_blank\'>Источник</a></div>
                                    <div class=\'col-5\'><a class=\'btn btn-warning btn-sm w-100\' onclick=\"notSuitable(' . $object['id'] .',' . $clientId . ')\">Не подходит</a></div>
                                    <div class=\'col-3\'><button class=\'btn btn-danger btn-sm w-100\' onclick=\"delOn(' . $object['id'] . ')\">Удалить</button></div>
                                </div>
                            </div>
                            <div class=\'col-12 mt-2\'>
                                <div class=\'row\'>
                                    <div class=\'col-4\'></div>
                                    <div class=\'col-5\'><a class=\'btn btn-outline-success btn-sm w-100\' onclick=\"nonСall(' . $object['id'] .',' . $clientId . ')\">Недозвон</a></div>
                                    <div class=\'col-3\'></div>
                                </div>
                            </div>
                ';
//                <div class=\'col-5\'><a class=\'btn btn-outline-success btn-sm w-100\' href=\'' . Url::to(['client-rent/non-call', 'id' => $object['id'], 'client' => $clientId]) . '\' role=\'button\'>Недозвон</a></div>
                if ($address) {
                    $balloonContentBody .= '
                            <div class=\'col-2 label mt-3\'>Адрес:</div>
                            <div class=\'col-10 address mt-3\'>' . $address . '</div>
                    ';
                }
                $balloonContentBody .= '
                        </div>
                    </div>
                ';
                  //      <p><a target=\'_blank\' href=\'' . Url::to(['not-parser-flat-rent/view', 'id' => $object['id'], 'client' => $clientId]) . '\'>' . $address . '</a></p><p>Цена: ' . $price . '</p><p><a target=\'_blank\' href=\'' . Url::to(['not-parser-flat-rent/view', 'id' => $object['id'], 'client' => $clientId]) . '\'>Карточка</a></p>';
                $hintContent          = '
                    <div class=\'hint-content mb-2 mt-2 mr-1 ml-1\'>
                        <div class=\'price mb-2\'>' . $price . '</div>
                        <div class=\'room\'>' . $room . '</div>
                    </div>
                ';
                $json .= '{
                    "type": "Feature", 
                    "id": ' . $object['id'] . ', 
                    "geometry": 
                    {
                        "type": "Point", 
                        "coordinates": [' . $object['latitude'] . ', ' . $object['longitude'] . ']
                    }, 
                    "properties": 
                    {
                        "balloonContentHeader": "' . str_replace(Params::mapStrReplace(), '', $balloonContentHeader) . '",  
                        "balloonContentBody": "' . str_replace(Params::mapStrReplace(), '', $balloonContentBody) . '", 
                        "clusterCaption": "' . $room . '", 
                        "hintContent": "' . str_replace(Params::mapStrReplace(), '', $hintContent) . '",
                        "iconContent": "' . $iconContent . '"
                    },
                    "options": {
                        "preset": "' . $iconColor . '"
                    }
                },';
            }
        }
        $json = rtrim($json, ',') . ']}';

        return json_encode($json);
    }

    private static function _prepareAmountArray($client) : array
    {
        $ret = [];
        if ($client['flat1'] && $client['amount_flat1']) {
            $ret['flat1Amount'] = $client['amount_flat1'];
        }
        if ($client['flat2'] && $client['amount_flat2']) {
            $ret['flat2Amount'] = $client['amount_flat2'];
        }
        if ($client['flat3'] && $client['amount_flat3']) {
            $ret['flat3Amount'] = $client['amount_flat3'];
        }
        if ($client['flat4'] && $client['amount_flat4']) {
            $ret['flat4Amount'] = $client['amount_flat4'];
        }
        if ($client['flat5'] && $client['amount_flat5']) {
            $ret['flat5Amount'] = $client['amount_flat5'];
        }
        if ($client['flat6'] && $client['amount_flat6']) {
            $ret['flat6Amount'] = $client['amount_flat6'];
        }
        if ($client['studio'] && $client['amount_studio']) {
            $ret['studioAmount'] = $client['amount_studio'];
        }
        if ($client['room'] && $client['amount_room']) {
            $ret['roomAmount'] = $client['amount_room'];
        }

        return $ret;
    }

    private static function _preparePolygonArray($client) : array
    {
        $z = [];
        $polygonsClient = explode('#', $client['polygons']);
        foreach ($polygonsClient as $polygon) {
            if ($polygon && $polygon != '[[],[]]') {
                $str = str_replace(']],[]]', '', $polygon);
                $str = str_replace('[[[', '', $str);
                $coors = explode('],[', $str);
                $tmp = [];
                foreach ($coors as $coor) {
                    list($x, $y) = explode(',', $coor);
                    $tmp[] = [$x, $y];
                }
                $z[] = $tmp;
            }
        }
        $ret['polygons'] = $z;

        return $ret;
    }
}

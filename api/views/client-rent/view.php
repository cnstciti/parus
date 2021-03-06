<?php
/**
 * @var string $info
 * @var string $objects
 * @var common\models\ar\ClientRentAR $clientId
 *
 */

use common\models\ar\ClientRentAR;
use common\models\ar\MyObjectAR;
use api\models\StatusON;
use yii\web\View;
use yii\helpers\Url;

$this->title = 'Клиент';

$clientId = $client['id'];
if ($client['zoom']) {
    $zoom = $client['zoom'];
} else {
    $zoom = 12;
}
if ($client['center']) {
    $center = $client['center'];
} else {
    $center = '[55.430640, 37.545424]';
}
$polygons = json_encode(explode('#', $client['polygons']));

?>
<?php /*
<script type="text/javascript">
  YMaps.jQuery(
    function(){
        var map=new YMaps.Map(YMaps.jQuery("#ym")[0]);
        map.setCenter(new YMaps.GeoPoint(37.64,55.76),10,YMaps.MapType.MAP);
        map.addControl(new YMaps.TypeControl());
        map.addControl(new YMaps.Zoom());
        map.addControl(new YMaps.SearchControl());
        var style=new YMaps.Style();
        style.polygonStyle=new YMaps.PolygonStyle();
        style.polygonStyle.fill=true;
        style.polygonStyle.outline=true;
        style.polygonStyle.strokeWidth=2;
        style.polygonStyle.strokeColor="ff0000ff";
        style.polygonStyle.fillColor="ff000077";
        var polygon=[];
        var cp=0;
        YMaps.Events.observe(map,map.Events.Click,function(){
            alert("Теперь можно рисовать полигон");
            polygon[cp]=new YMaps.Polygon();
            polygon[cp].setStyle(style);
            polygon[cp].name=cp;
            map.addOverlay(polygon[cp]);
            polygon[cp].setEditingOptions({drawing:true});
            polygon[cp].startEditing();
            cp++;
        });
        YMaps.jQuery("#crd").click(function() {
            var pts=[];
            for(var i=0;i<polygon.length;i++) {
                var temp1=polygon[i].getPoints().toString().split(",");
                var temp2=[];
                for(var j=0;j<temp1.length/2;j++) {
                    temp2.push("["+ temp1[j*2] +","+ temp1[j*2+1] +"]");
                }
                pts.push("["+temp2.join(",")+"]");
            }
            YMaps.jQuery("#out").html(pts.join("<br><br>")+"<br><br>Zoom:<br>"+map.getZoom()
                +"<br><br>Center:<br>"+map.getCenter());
        });
    });

</script>
*/ ?>
<h2><?= $this->title ?></h2>
<div class="row">
    <div class="col-4">
        <div class="row">
            <div class="col-12">
                <?= $info ?>
            </div>
            <div class="col-12">
                <?= $objects ?>
            </div>
            <div class="col-12">
                <button id="saveData">Сохранить</button>
            </div>
        </div>
    </div>
    <div class="col-8">
        <div id="msgError" style="color: red; font-size: 1.1rem;"></div>
        <button id="startEdit">Включить редактирование</button>
        <button id="stopEdit">Отключить редактирование</button>
        <button id="newArea">Новая область</button>
        <button id="delAll">Удалить всё</button>
        <div id="map" style="width:800px; height:580px"></div>
        <? /*<div id="geometry"/></div>*/ ?>
    </div>
</div>

<?php
$urlSave = Url::to(['client-rent/save']);
$urlMapObjects = Url::to(['client-rent/map-objects']);
$js = <<< JS
    // Функция ymaps.ready() будет вызвана, когда
    // загрузятся все компоненты API, а также когда будет готово DOM-дерево.
    ymaps.ready(init);

    function init() {
        // Создание карты.
        // https://tech.yandex.ru/maps/doc/jsapi/2.1/dg/concepts/map-docpage/
        var myMap = new ymaps.Map("map", {
            // Координаты центра карты.
            // Порядок по умолчнию: «широта, долгота».
            center: $center,
            // Уровень масштабирования. Допустимые значения:
            // от 0 (весь мир) до 19.
            zoom: $zoom,
            // Элементы управления
            // https://tech.yandex.ru/maps/doc/jsapi/2.1/dg/concepts/controls/standard-docpage/
            controls: [
                'zoomControl', // Ползунок масштаба
            ]
        }),
        objectManager = new ymaps.ObjectManager({
            // Чтобы метки начали кластеризоваться, выставляем опцию.
            clusterize: true,
            // ObjectManager принимает те же опции, что и кластеризатор.
            gridSize: 32,
            clusterDisableClickZoom: true
        });
        
        objectManager.clusters.options.set('preset', 'islands#greenClusterIcons');
        myMap.geoObjects.add(objectManager);

        $.ajax({
            type: 'POST',
            url: '$urlMapObjects',
            dataType: 'json',
            data: {
                clientId: '$clientId'
            },
            error: function() {
                $('#msgError').html('Ошибка получения данных. Обновите страницу!');
                console.log('MapObjects. Ошибка выполнения');
            },
            complete: function() { console.log('MapObjects. Завершение выполнения'); }
        }).done(function(data) {
            objectManager.add(data);
        });

        var paramPolygon=$polygons;
        //console.log(paramPolygon);
        //console.log(JSON.parse(paramPolygon[0]));
        //var paramPolygon=[[[55.4346,37.5470],[55.4323,37.5537],[55.4306,37.5512],[55.4328,37.5454],[55.4346,37.5470]],[]];
        //console.log(paramPolygon);
        var myPolygon=[];
        var cp=0;

        //console.log('paramPolygon.length='+paramPolygon.length);
        //console.log(paramPolygon);
        for(var i=0;i<paramPolygon.length;i++) {
            //console.log('paramPolygon.cp='+typeof(paramPolygon[i]));
            //console.log(JSON.parse(paramPolygon[cp]));
            if (paramPolygon[i]) {
                myPolygon[i] = new ymaps.Polygon(JSON.parse(paramPolygon[i]), {}, {
                    editorDrawingCursor: "crosshair",  // Курсор в режиме добавления новых вершин.
                    editorMaxPoints: 100, // Максимально допустимое количество вершин.
                    fill: true, // Наличие заливки
                    fillColor: '64a0fc40', // Цвет заливки.
                    strokeColor: '64a0fc', // Цвет обводки.
                    strokeWidth: 2, // Ширина обводки.
                    editorMenuManager: function (items) {return items.slice(0, -1)}
                });
                myMap.geoObjects.add(myPolygon[i]);
                cp++;
            }
        }

        /*
        var p = new ymaps.Polygon([[[55.7926,37.5942],[55.7913,37.5303],[55.8120,37.5629],[55.7926,37.5942]],[]], 
                {}, {
                // Курсор в режиме добавления новых вершин.
                editorDrawingCursor: "crosshair",
                // Максимально допустимое количество вершин.
                editorMaxPoints: 30,
                fill: true, // Наличие заливки
                fillColor: '0066ff99', // Цвет заливки.
                strokeColor: '0000FF', // Цвет обводки.
                strokeWidth: 2, // Ширина обводки.
                editorMenuManager: function (items) {return items.slice(0, -1)}
            });
        myMap.geoObjects.add(p);
        */
        // Включаем режим редактирования полигона
        $('#startEdit').on('click', function () {
            for(var i=0;i<myPolygon.length;i++) {
                myPolygon[i].editor.startEditing();
                //myPolygon[i].editor.startDrawing();
            }
        });

        // Отключаем режим редактирования полигона
        $('#stopEdit').on('click', function () {
            for(var i=0;i<myPolygon.length;i++) {
                myPolygon[i].editor.stopDrawing();
                myPolygon[i].editor.stopEditing();
            }
        });

        // Новый полигон
        $('#newArea').on('click', function () {
            myPolygon[cp] = new ymaps.Polygon([
                [], // Координаты внешнего контура
                [] // Координаты внутреннего контура
            ], {}, {
                editorDrawingCursor: "crosshair", // Курсор в режиме добавления новых вершин.
                editorMaxPoints: 100, // Максимально допустимое количество вершин.
                fill: true, // Наличие заливки
                fillColor: '64a0fc40', // Цвет заливки.
                strokeColor: '64a0fc', // Цвет обводки.
                strokeWidth: 2, // Ширина обводки.
                editorMenuManager: function (items) {return items.slice(0, -1)}
            });
            myMap.geoObjects.add(myPolygon[cp]);
            myPolygon[cp].editor.startDrawing();
            cp++;
        });

        // Cохранение данных
        $('#saveData').on('click', function () {
            s='';
            //console.log('myPolygon.length='+myPolygon.length);
            for(var i=0;i<myPolygon.length;i++) {
                s += stringify(myPolygon[i].geometry.getCoordinates())+'#';
            }
            $.ajax({
                type: 'POST',
                url: '$urlSave',
                dataType: 'json',
                data: {
                    polygons: stringify(s),
                    zoom: myMap.getZoom(),
                    center: myMap.getCenter(),
                    clientId: '$clientId'
                },
                /*
                success: function(data) { 
                    console.log(data); 
                    // обрабатываем ответ сервера
                    z='';
                    for(var i=0;i<myPolygon.length;i++) {
                        z += '<br><br>Полигон '+i+': '+stringify(myPolygon[i].geometry.getCoordinates());
                    }
                    z += '<br><br>Zoom:<br>'+myMap.getZoom()+"<br><br>Center:<br>"+myMap.getCenter();
        
                    $('#geometry').html('Результаты: ' + z);
                }, // обработка ответа от сервера
                */
                error: function() { console.log('Ошибка выполнения'); },
                complete: function() { console.log('Завершение выполнения'); }
            });
        });

        function stringify (coords) {
            var res = '';
            if ($.isArray(coords)/* && coords.length*/) {
                res = '[';
                for (var i = 0, l = coords.length; i < l; i++) {
                    if (i > 0) {
                        res += ',';
                        //console.log(res);
                    }
                    res += stringify(coords[i]);
                }
                res += ']';
            } else if (typeof coords == 'number') {
                res = coords.toPrecision(6);
            } else if (coords.toString) {
                res = coords.toString();
            }
            return res;
        }
        
        // Отключаем режим редактирования полигона
        $('#delAll').on('click', function () {
            for(var i=0;i<myPolygon.length;i++) {
                myMap.geoObjects.remove(myPolygon[i]);
            }
            myPolygon.length=0;
            cp=0;
        });

    }

    /*
    // Как только будет загружен API и готов DOM, выполняем инициализацию
    ymaps.ready(init);

    function init () {
        var myMap = new ymaps.Map("map", {
                center: [55.465958, 37.550348],
                zoom: 12
            }),
            polygon = new ymaps.GeoObject({
                geometry: {
                    type: "Polygon",
                    coordinates: []
                }
            });

        myMap.geoObjects.add(polygon);
        polygon.editor.startDrawing();

        $('input').attr('disabled', false);

        // Обработка нажатия на любую кнопку.
        $('input').click(
            function () {
                // Отключаем кнопки, чтобы на карту нельзя было
                // добавить более одного редактируемого объекта (чтобы в них не запутаться).
                $('input').attr('disabled', true);
                polygon.editor.stopEditing();
                printGeometry(polygon.geometry.getCoordinates());
            }
        );
    }

    // Выводит массив координат геообъекта в <div id="geometry">
    function printGeometry (coords) {
        $('#geometry').html('Координаты: ' + stringify(coords));

        function stringify (coords) {
            var res = '';
            if ($.isArray(coords)) {
                res = '[ ';
                for (var i = 0, l = coords.length; i < l; i++) {
                    if (i > 0) {
                        res += ', ';
                    }
                    res += stringify(coords[i]);
                }
                res += ' ]';
            } else if (typeof coords == 'number') {
                res = coords.toPrecision(6);
            } else if (coords.toString) {
                res = coords.toString();
            }

            return res;
        }
    }
     */
JS;

$this->registerJs($js, View::POS_END);
?>
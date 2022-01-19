<?php
/**
 * @var \yii\web\View $this
 * @var yii\data\ArrayDataProvider $dataProvider
 *
 */

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = 'Клиенты. Аренда';
?>
<? /*<h2><?= $this->title ?></h2>*/ ?>
<?php
$gridColumn = [
    [
        'label'     => 'ИД',
        'attribute' => 'id',
        'hAlign' => GridView::ALIGN_CENTER,
    ],
    [
        'label'  => 'Имя',
        'format' => 'raw',
        'value'  => function ($row) {
            return Html::a($row['name'], ['view', 'id' => $row['id']], ['title' => 'Просмотр']);
        },
    ],
    [
        'label'  => 'Телефон',
        'format' => 'raw',
        'value'  => function ($row) {
            return isset($row['search_date']) ? Yii::$app->formatter->asPhone($row['phone']) : '---';
        },
        'hAlign' => GridView::ALIGN_CENTER,
    ],
    [
        'label'  => 'Поиск ДО',
        'format' => 'raw',
        'value'  => function ($row) {
            return isset($row['search_date']) ? Yii::$app->formatter->asDate($row['search_date'], 'dd.MM.yyyy') : '---';
        },
        'hAlign' => GridView::ALIGN_CENTER,
    ],
    [
        'label'     => 'Пользователь',
        'format' => 'raw',
        'value'  => function ($row) {
            return isset($row['username']) ? $row['username'] : '---';
        },
        'hAlign' => GridView::ALIGN_CENTER,
    ],
    [
        'label'  => 'Действия',
        'format' => 'raw',
        'value'  => function ($row) {
            return Html::a('Удалить', Url::to(['client-rent/delete', 'id' => $row['id']]));
            /*
            return Html::a(
                '<span class="fas fa-pen"></span>',
                '#',
                [
                    'data-pjax'   => 0,
                    'class'       => 'btn btn-info ml-4 show-edit-modal',
                    'data-target' => Url::to(['agent/edit', 'id' => $row['id']]),
                    'title' => 'Редактировать',
                ]
            );
            */
        },
    ],
    /*
    [
        'format' => 'raw',
        'value'  => function ($row) {
            return Html::a('Редактировать', ['view', 'id' => $row['id']]);
        },
    ],
    [
        'label'     => 'Комнат в квартире',
        'attribute' => 'myRooms',
        'hAlign'    => GridView::ALIGN_CENTER,
    ],
    [
        'label'     => 'Этаж',
        'value'     => function ($row) {
            return $row['myFloor'] . ' / ' . $row['myNumberOfFloors'];
        },
        'hAlign'    => GridView::ALIGN_CENTER,
        'width'     => '80px',
    ],
    [
        'label'     => 'Адрес',
        'attribute' => 'realAddress',
    ],
    [
        'label'     => 'Цена',
        'attribute' => 'price',
        'hAlign'    => GridView::ALIGN_RIGHT,
        'width'     => '110px',
        'value'     => function ($row) {
            $icon = '';
            if ($row['newPrice'] && $row['myPrice'] != $row['newPrice']) {
                $icon = '<i class="fas fa-exclamation-triangle text-danger" title="Цена изменена"></i>&nbsp;&nbsp;';
            }
            return $icon . $row['price'];
        },
        'format' => 'raw',
    ],
    */
];
$linkAdd = Html::a('<i class="fas fa-plus mr-2"></i>Добавить клиента', Url::to(['client-rent/add']), ['class' => 'btn btn-success']);
//$linkReset = Html::a('<i class="fas fa-filter mr-2"></i>Сбросить фильтры', Url::to(['client-rent/list']), ['class' => 'btn btn-primary']);

echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        //'filterModel'  => $searchModel,
        'columns'      => $gridColumn,
        'responsive'   => true,
        'panel'        => [
            'type'    => GridView::TYPE_SUCCESS,
            'footer'  => false,
            'heading' => 'Список клиентов (аренда)',
            'before'  => $linkAdd,
//            'after'   => $linkReset,
        ],
        'toolbar'      => [
            [
                'content' => '',
                //'content' => $linkReset,
            ],
        ],
    ]
);

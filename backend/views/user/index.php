<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ArrayDataProvider $dataProvider
 *
 */

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

//IndexAsset::register($this);

$this->title = 'Пользователи';

$gridColumn = [
    [
        'label'     => 'ИД',
        'attribute' => 'id',
        'hAlign' => GridView::ALIGN_CENTER,
    ],
    [
        'label'     => 'Имя',
        'attribute' => 'username',
    ],
    [
        'label'     => 'Статус',
        'format' => 'raw',
        'value'  => function ($row) {
            if ($row['status'] == 10) {
                return 'Зарегистрирован';
            }
            return 'Требует подтверждения';
        },
        'hAlign' => GridView::ALIGN_CENTER,
    ],
    [
        'label'  => 'Действия',
        'format' => 'raw',
        'value'  => function ($row) {
            return Html::a('Сменить статус', Url::to(['user/change-status', 'id' => $row['id']]));
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
];
//$linkAdd   = Html::a('<i class="fas fa-plus mr-2"></i>Добавить клиента', Url::to(['client-rent/add']), ['class' => 'btn btn-success']);
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
            'heading' => 'Пользователи',
//            'before'  => $linkAdd,
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

/*
//$this->title = $title . ' / ' . Yii::$app->params['constRooms'];
//$this->title = $title . ' / ' . Yii::$app->params['constRooms'] . ' / ' . Yii::$app->params['constSale'];



echo FlatListWidget::widget([
    'title'        => $this->title,
    'controller'   => $controller,
    'dataProvider' => $dataProvider,
    'searchModel'  => $searchModel,
    'gridColumn'   => $gridColumn,
]);
*/
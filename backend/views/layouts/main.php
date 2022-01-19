<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;
use backend\models\auth\Role;
use yii\helpers\ArrayHelper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=f15e255e-67d2-41db-b45b-492c7749135b&lang=ru_RU" type="text/javascript"></script>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    if (Yii::$app->user->isGuest) {
        $homeUrl = Yii::$app->homeUrl;
    } else {
        $homeUrl = Url::to(['site/index-lk']);
    }
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        //'brandUrl' => Yii::$app->homeUrl,
        'brandUrl' => $homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    /*
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    */
    if (Yii::$app->user->isGuest) {
        $items[] = ['label' => 'Вход', 'url' => Url::to(['site/login'])];
        $items[] = ['label' => 'Регистрация', 'url' => Url::to(['site/signup'])];
    } else {
        /*
        $items = [
            ['label' => 'Главная', 'url' => Url::to(['site/index'])],
            ['label' => Yii::$app->params['constObjects'], 'items' => [
                '<div class="dropdown-header">' . Yii::$app->params['constFlats'] . '</div>',
                ['label' => Yii::$app->params['constSale'], 'url' => Url::to(['parser-flat-sale/list']), 'linkOptions' => ['class' => 'sale']],
                ['label' => Yii::$app->params['constRent'], 'url' => Url::to(['parser-flat-rent/list']), 'linkOptions' => ['class' => 'rent']],
                //['label' => Yii::$app->params['constFlats'], 'url' => Url::to(['parser-flat/list'])],
                '<div class="dropdown-divider"></div>',
                '<div class="dropdown-header">' . Yii::$app->params['constRooms'] . '</div>',
                ['label' => Yii::$app->params['constSale'], 'url' => Url::to(['parser-room-sale/list']), 'linkOptions' => ['class' => 'sale']],
                ['label' => Yii::$app->params['constRent'], 'url' => Url::to(['parser-room-rent/list']), 'linkOptions' => ['class' => 'rent']],
                //['label' => Yii::$app->params['constRooms'], 'url' => Url::to(['parser-room/list'])],

                //['label' => Yii::$app->params['constHouses'], 'url' => Url::to(['parser-house/list'])],
                //['label' => Yii::$app->params['constLands'], 'url' => Url::to(['parser-land/list'])],
            ]],
            ['label' => 'Клиенты', 'url' => Url::to(['client-rent/list'])],
            ['label' => Yii::$app->params['constNOTObjects'], 'items' => [
                //['label' => Yii::$app->params['constRent'], 'url' => Url::to(['not-parser-rent/list'])],
                '<div class="dropdown-header">' . Yii::$app->params['constFlats'] . '</div>',
                ['label' => Yii::$app->params['constSale'], 'url' => Url::to(['not-parser-flat-sale/list']), 'linkOptions' => ['class' => 'sale']],
                ['label' => Yii::$app->params['constRent'], 'url' => Url::to(['not-parser-flat-rent/list']), 'linkOptions' => ['class' => 'rent']],
                //['label' => Yii::$app->params['constFlats'], 'url' => Url::to(['not-parser-flat/list'])],
                '<div class="dropdown-divider"></div>',
                '<div class="dropdown-header">' . Yii::$app->params['constRooms'] . '</div>',
                ['label' => Yii::$app->params['constSale'], 'url' => Url::to(['not-parser-room-sale/list']), 'linkOptions' => ['class' => 'sale']],
                ['label' => Yii::$app->params['constRent'], 'url' => Url::to(['not-parser-room-rent/list']), 'linkOptions' => ['class' => 'rent']],
                //['label' => Yii::$app->params['constRooms'], 'url' => Url::to(['not-parser-room/list'])],

                //['label' => Yii::$app->params['constHouses'], 'url' => Url::to(['not-parser-house/list'])],
                //['label' => Yii::$app->params['constLands'], 'url' => Url::to(['not-parser-land/list'])],
            ]],
            ['label' => 'Агенты', 'url' => Url::to(['agent/list'])],
            ['label' => 'Прокси', 'items' => [
                ['label' => 'Доступность сервиса', 'url' => Url::to(['proxy/test'])],
                '<div class="dropdown-divider"></div>',
                '<div class="dropdown-header">Загрузка прокси-адресов</div>',
                ['label' => 'Тип адреса неизвестен', 'url' => Url::to(['proxy/address-load-unknown'])],
                ['label' => 'Тип адреса - HTTP', 'url' => Url::to(['proxy/address-load-http'])],
            ]],
        ];
*/
        if (Yii::$app->user->can(Role::ADMIN_NAME)) {
            $items[] = ['label' => 'Клиенты', 'url' => Url::to(['client-rent/index-admin'])];
            $items[] = ['label' => 'Пользователи', 'url' => Url::to(['user/index'])];
        } else {
            $items[] = ['label' => 'Клиенты', 'url' => Url::to(['client-rent/index'])];
        }

        $auth[] = '<li>'
            . Html::beginForm(['site/logout'], 'post')
            . Html::submitButton(
                'Выход (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout', 'style' => 'padding-top:8px']
            )
            . Html::endForm()
            . '</li>';

        $items = ArrayHelper::merge($items, $auth);
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();

<?php
/**
 * @var array $params
 * @var $idButton string
 *
 */

use yii\bootstrap4\Modal;
use yii\web\View;

$noData     = '---';
$name       = empty($params['client']['name'])        ? $noData : $params['client']['name'];
$phone      = empty($params['client']['phone'])       ? $noData : $params['client']['phone'];
$phone      = Yii::$app->formatter->asPhone($phone);
$whatsApp   = empty($params['client']['whats_app'])   ? $noData : $params['client']['whats_app'];
$whatsApp   = Yii::$app->formatter->asPhone($whatsApp);
$telegram   = empty($params['client']['telegram'])    ? $noData : $params['client']['telegram'];
$adults     = empty($params['client']['adults'])      ? $noData : $params['client']['adults'];
$children   = empty($params['client']['children'])    ? $noData : $params['client']['children'];
$animals    = $params['client']['animals']            ? 'Да'    : $noData;
$searchDate = empty($params['client']['search_date']) ? $noData : $params['client']['search_date'];
$canView    = empty($params['client']['can_view'])    ? $noData : $params['client']['can_view'];
$comment    = empty($params['client']['comment'])     ? $noData : $params['client']['comment'];

?>
<div class="row">
    <div class="col-6">
        Имя:
    </div>
    <div class="col-6">
        <?= $name ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        Телефон:
    </div>
    <div class="col-6">
        <?= $phone ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        WhatsApp:
    </div>
    <div class="col-6">
        <?= $whatsApp ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        Телеграм:
    </div>
    <div class="col-6">
        <?= $telegram ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        Взрослые:
    </div>
    <div class="col-6">
        <?= $adults ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        Дети:
    </div>
    <div class="col-6">
        <?= $children ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        Животные:
    </div>
    <div class="col-6">
        <?= $animals ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        Поиск ДО даты:
    </div>
    <div class="col-6">
        <?= $searchDate ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        Просматривают:
    </div>
    <div class="col-6">
        <?= $canView ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        Комментарий:
    </div>
    <div class="col-6">
        <?= $comment ?>
    </div>
</div>

<?php
Modal::begin([
    'title' => 'Редактирование клиента',
    'id'    => 'client-modal',
    'size'  => 'modal-lg',
]);
?>

<div id="client-content">
    <div class="text-center"><img src="<?= Yii::getAlias('@img') ?>/loading.gif" /></div>
</div>

<?php Modal::end(); ?>

<?php
$idButton = $params['idButton'];
$js = <<< JS
$('#$idButton').on('click', function() {showModal('#client-modal', '#client-content', $(this))});
JS;

$this->registerJs($js, View::POS_END);
?>

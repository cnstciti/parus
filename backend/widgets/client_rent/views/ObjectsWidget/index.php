<?php
/**
 * @var array $params
 * @var $idButton string
 *
 */

use yii\bootstrap4\Modal;
use yii\web\View;
/*
$noData     = '---';
$name       = empty($params['client']['name'])        ? $noData : $params['client']['name'];
$phone      = empty($params['client']['phone'])       ? $noData : $params['client']['phone'];
$phone      = Yii::$app->formatter->asPhone($phone);
$whatsApp   = empty($params['client']['whats_app'])   ? $noData : $params['client']['whats_app'];
$whatsApp      = Yii::$app->formatter->asPhone($whatsApp);
$telegram   = empty($params['client']['telegram'])    ? $noData : $params['client']['telegram'];
$adults     = empty($params['client']['adults'])      ? $noData : $params['client']['adults'];
$children   = empty($params['client']['children'])    ? $noData : $params['client']['children'];
$animals    = $params['client']['flat1'] ? 'Да' : 'Нет';
$searchDate = empty($params['client']['search_date']) ? $noData : $params['client']['search_date'];
$canView    = empty($params['client']['can_view'])    ? $noData : $params['client']['can_view'];
$comment    = empty($params['client']['comment'])     ? $noData : $params['client']['comment'];
*/
?>
<div>
    <? if ($params['client']['flat1'] && $params['client']['amount_flat1']) : ?>
        <div class="row">
            <div class="col-6">
                1-к. кв.
            </div>
            <div class="col-6">
                <?= number_format($params['client']['amount_flat1'], 0, '.', ' ') ?>
            </div>
        </div>
    <? endif; ?>
    <? if ($params['client']['flat2'] && $params['client']['amount_flat2']) : ?>
        <div class="row">
            <div class="col-6">
                2-к. кв.
            </div>
            <div class="col-6">
                <?= number_format($params['client']['amount_flat2'], 0, '.', ' ') ?>
            </div>
        </div>
    <? endif; ?>
    <? if ($params['client']['flat3'] && $params['client']['amount_flat3']) : ?>
        <div class="row">
            <div class="col-6">
                3-к. кв.
            </div>
            <div class="col-6">
                <?= number_format($params['client']['amount_flat3'], 0, '.', ' ') ?>
            </div>
        </div>
    <? endif; ?>
    <? if ($params['client']['flat4'] && $params['client']['amount_flat4']) : ?>
        <div class="row">
            <div class="col-6">
                4-к. кв.
            </div>
            <div class="col-6">
                <?= number_format($params['client']['amount_flat4'], 0, '.', ' ') ?>
            </div>
        </div>
    <? endif; ?>
    <? if ($params['client']['flat5'] && $params['client']['amount_flat5']) : ?>
        <div class="row">
            <div class="col-6">
                5-к. кв.
            </div>
            <div class="col-6">
                <?= number_format($params['client']['amount_flat5'], 0, '.', ' ') ?>
            </div>
        </div>
    <? endif; ?>
    <? if ($params['client']['flat6'] && $params['client']['amount_flat6']) : ?>
        <div class="row">
            <div class="col-6">
                6-к. кв.
            </div>
            <div class="col-6">
                <?= number_format($params['client']['amount_flat6'], 0, '.', ' ') ?>
            </div>
        </div>
    <? endif; ?>
    <? if ($params['client']['studio'] && $params['client']['amount_studio']) : ?>
        <div class="row">
            <div class="col-6">
                Студия
            </div>
            <div class="col-6">
                <?= number_format($params['client']['amount_studio'], 0, '.', ' ') ?>
            </div>
        </div>
    <? endif; ?>
    <? if ($params['client']['room'] && $params['client']['amount_room']) : ?>
        <div class="row">
            <div class="col-6">
                Комната
            </div>
            <div class="col-6">
                <?= number_format($params['client']['amount_room'], 0, '.', ' ') ?>
            </div>
        </div>
    <? endif; ?>
</div>

<?php
Modal::begin([
    'title' => 'Редактирование объектов',
    'id'    => 'objects-modal',
    'size'  => 'modal-md',
]);
?>

<div id="objects-content">
    <div class="text-center"><img src="<?= Yii::getAlias('@img') ?>/loading.gif" /></div>
</div>

<?php Modal::end(); ?>

<?php
$idButton = $params['idButton'];
$js = <<< JS
$('#$idButton').on('click', function() {showModal('#objects-modal', '#objects-content', $(this))});
JS;

$this->registerJs($js, View::POS_END);
?>

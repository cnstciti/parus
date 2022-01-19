<?php
/**
 * @var $model backend\models\form\AddressForm
 *
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;

$form = ActiveForm::begin([
//    'id' => 'login-form-horizontal',
    //'type' => ActiveForm::TYPE_HORIZONTAL,
    //'formConfig' => ['labelSpan' => 4, 'deviceSize' => ActiveForm::SIZE_SMALL]
]);
?>

<div class="row">
    <div class="col-6">
    </div>
    <div class="col-6">
        бюджет ДО
    </div>
</div>
<div class="row">
    <div class="col-6">
        <?= $form->field($model, 'flat1')->checkbox() ?>
    </div>
    <div class="col-6">
        <?= $form->field($model, 'amount_flat1', [
                'showLabels' => false,
                'addon' => ['append' => ['content'=>'руб.']],
            ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <?= $form->field($model, 'flat2')->checkbox() ?>
    </div>
    <div class="col-6">
        <?= $form->field($model, 'amount_flat2', [
                'showLabels' => false,
                'addon' => ['append' => ['content'=>'руб.']],
            ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <?= $form->field($model, 'flat3')->checkbox() ?>
    </div>
    <div class="col-6">
        <?= $form->field($model, 'amount_flat3', [
            'showLabels' => false,
            'addon' => ['append' => ['content'=>'руб.']],
        ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <?= $form->field($model, 'flat4')->checkbox() ?>
    </div>
    <div class="col-6">
        <?= $form->field($model, 'amount_flat4', [
            'showLabels' => false,
            'addon' => ['append' => ['content'=>'руб.']],
        ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <?= $form->field($model, 'flat5')->checkbox() ?>
    </div>
    <div class="col-6">
        <?= $form->field($model, 'amount_flat5', [
            'showLabels' => false,
            'addon' => ['append' => ['content'=>'руб.']],
        ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <?= $form->field($model, 'flat6')->checkbox() ?>
    </div>
    <div class="col-6">
        <?= $form->field($model, 'amount_flat6', [
            'showLabels' => false,
            'addon' => ['append' => ['content'=>'руб.']],
        ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <?= $form->field($model, 'studio')->checkbox() ?>
    </div>
    <div class="col-6">
        <?= $form->field($model, 'amount_studio', [
            'showLabels' => false,
            'addon' => ['append' => ['content'=>'руб.']],
        ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <?= $form->field($model, 'room')->checkbox() ?>
    </div>
    <div class="col-6">
        <?= $form->field($model, 'amount_room', [
            'showLabels' => false,
            'addon' => ['append' => ['content'=>'руб.']],
        ]) ?>
    </div>
</div>
<div class="text-right">

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>

</div>

<?php ActiveForm::end(); ?>

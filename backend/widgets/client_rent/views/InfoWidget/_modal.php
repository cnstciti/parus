<?php
/**
 * @var $model backend\models\form\AddressForm
 *
 */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use kartik\date\DatePicker;

$form = ActiveForm::begin();
if (empty($model->search_date)) {
    $model->search_date = date("d.m.Y");
}
?>

<div class="row">
    <div class="col-4">

        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Введите имя клиента']) ?>
        <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Введите телефон клиента']) ?>
        <?= $form->field($model, 'whats_app')->textInput(['placeholder' => 'Введите WhatsApp клиента']) ?>
        <?= $form->field($model, 'telegram')->textInput(['placeholder' => 'Введите Telegrem клиента']) ?>

    </div>
    <div class="col-8">
        <div class="row">
            <div class="col-6">

                <?= $form->field($model, 'adults')->textInput(['placeholder' => 'Введите проживающих']) ?>
                <?= $form->field($model, 'children')->textInput(['placeholder' => 'Введите проживающих детей']) ?>
                <?= $form->field($model, 'animals')->checkbox() ?>

            </div>
            <div class="col-6">

                <?= $form->field($model, 'search_date')->widget(DatePicker::classname(), [
                    'readonly'      => true,
                    'removeButton'  => false,
                    //'size' =>'lg',
                    //'value'  => $model->dateLastCall1,
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'autoclose'      => true,
                        //'orientation'    => 'top left',
                        'todayHighlight' => true,
                        'todayBtn'       => true,
                        'format'         => 'dd.MM.yyyy',
                        'startDate'      => date("y-m-d H:i:s"),
                        //'defaultViewDate' => date("y-m-d H:i:s", time()),
                    ]
                ]) ?>
                <?= $form->field($model, 'can_view')->textInput(['placeholder' => 'Введите время просмотра']) ?>

            </div>
        </div>
        <div class="row">
            <div class="col-12">

                <?= $form->field($model, 'comment')->textarea(['placeholder' => 'Введите комментарий']) ?>

            </div>
        </div>
    </div>
</div>
<div class="text-right">

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>

</div>

<?php ActiveForm::end(); ?>

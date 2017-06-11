<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Guia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="guia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'num_guia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_envio')->textInput() ?>

    <?= $form->field($model, 'monto_subtotal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'monto_igv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'monto_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_digitada')->textInput() ?>

    <?= $form->field($model, 'fecha_modificada')->textInput() ?>

    <?= $form->field($model, 'fecha_eliminada')->textInput() ?>

    <?= $form->field($model, 'usuario_digitado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'usuario_modificado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'usuario_eliminado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'host')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

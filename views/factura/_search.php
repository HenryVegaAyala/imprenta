<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FacturaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="factura-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'num_factura') ?>

    <?= $form->field($model, 'fecha_pago') ?>

    <?= $form->field($model, 'monto_subtotal') ?>

    <?= $form->field($model, 'monto_igv') ?>

    <?php // echo $form->field($model, 'monto_total') ?>

    <?php // echo $form->field($model, 'fecha_digitada') ?>

    <?php // echo $form->field($model, 'fecha_modificada') ?>

    <?php // echo $form->field($model, 'fecha_eliminada') ?>

    <?php // echo $form->field($model, 'usuario_digitado') ?>

    <?php // echo $form->field($model, 'usuario_modificado') ?>

    <?php // echo $form->field($model, 'usuario_eliminado') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'host') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

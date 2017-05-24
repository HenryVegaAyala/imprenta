<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'apellido') ?>

    <?= $form->field($model, 'telefono') ?>

    <?= $form->field($model, 'dni') ?>

    <?php // echo $form->field($model, 'correo') ?>

    <?php // echo $form->field($model, 'privilegio') ?>

    <?php // echo $form->field($model, 'contrasena') ?>

    <?php // echo $form->field($model, 'contrasena_desc') ?>

    <?php // echo $form->field($model, 'authKey') ?>

    <?php // echo $form->field($model, 'accessToken') ?>

    <?php // echo $form->field($model, 'fecha_digitada') ?>

    <?php // echo $form->field($model, 'fecha_modificada') ?>

    <?php // echo $form->field($model, 'fecha_eliminada') ?>

    <?php // echo $form->field($model, 'usuario_digitado') ?>

    <?php // echo $form->field($model, 'usuario_modificado') ?>

    <?php // echo $form->field($model, 'usuario_eliminado') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'host') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'genero') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

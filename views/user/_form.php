<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$descripcion = "Registrar Usuario";
?>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="container-fluid">
                    <span class="section"><?php echo Html::encode($descripcion) ?></span>
                    <?php
                    Pjax::begin();
                    $form = ActiveForm::begin(
                        [
                            'enableAjaxValidation' => false,
                            'enableClientValidation' => true,
                            'method' => 'post',
                            'options' => [
                                'class' => 'form-horizontal form-label-left',
                                'novalidate' => "true",
                                'data-pjax' => true,
                            ],
                        ]
                    ); ?>
                    <div class="row">
                        <div class="item form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'nombre')->textInput(
                                    ['maxlength' => true],
                                    ['class' => 'form-control col-md-7 col-xs-12']
                                ) ?>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'apellido')->textInput(
                                    ['maxlength' => true],
                                    ['class' => 'form-control col-md-7 col-xs-12']) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'dni')->textInput(
                                ['maxlength' => true],
                                ['class' => 'form-control col-md-7 col-xs-12']) ?>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'privilegio')->textInput(
                                ['maxlength' => true],
                                ['class' => 'form-control col-md-7 col-xs-12']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'correo')->textInput(
                                ['maxlength' => true],
                                ['class' => 'form-control col-md-7 col-xs-12']) ?>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'contrasena')->textInput(
                                ['maxlength' => true],
                                ['class' => 'form-control col-md-7 col-xs-12']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'telefono')->textInput(
                                ['maxlength' => true],
                                ['class' => 'form-control col-md-7 col-xs-12']) ?>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'genero')->textInput(
                                ['maxlength' => true],
                                ['class' => 'form-control col-md-7 col-xs-12']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'fecha_inicio')->textInput(
                                ['maxlength' => true],
                                ['class' => 'form-control col-md-7 col-xs-12']) ?>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'fecha_cumpleanos')->textInput(
                                ['maxlength' => true],
                                ['class' => 'form-control col-md-7 col-xs-12']) ?>
                        </div>
                    </div>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                        <?= Html::resetButton('Cancelar', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end();
                Pjax::end();
                ?>
            </div>
        </div>
    </div>
</div>
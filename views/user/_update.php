<?php

use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$descripcion = "Actualizar Usuario";
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
                            <?= $form->field($model, 'privilegio')->dropDownList($model->rol(), [
                                'prompt' => 'Seleccionar Rol',
                                'class' => 'form-control col-md-7 col-xs-12',
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'correo')->textInput(
                                ['maxlength' => true],
                                ['class' => 'form-control col-md-7 col-xs-12']) ?>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'contrasena')->passwordInput(
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
                            <?= $form->field($model, 'genero')->dropDownList($model->genero(), [
                                'prompt' => 'Seleccionar Género',
                                'class' => 'form-control col-md-7 col-xs-12',
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'fecha_inicio')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => ''],
                                'value' => date('d-M-Y'),
                                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-mm-yyyy',
                                    'todayHighlight' => true,
                                    'class' => 'form-control col-md-7 col-xs-12',
                                ],
                            ]);
                            ?>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'fecha_cumpleanos')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => ''],
                                'value' => date('d-M-Y'),
                                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-mm-yyyy',
                                    'todayHighlight' => true,
                                    'class' => 'form-control col-md-7 col-xs-12',
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end();
                Pjax::end();
                ?>
            </div>
        </div>
    </div>
</div>
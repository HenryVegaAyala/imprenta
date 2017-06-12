<?php

use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Proforma */
/* @var $form yii\widgets\ActiveForm */
$descripcion = "Registrar Proformar";
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
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'num_proforma')->textInput(
                                    ['maxlength' => 12],
                                    ['class' => 'form-control col-md-7 col-xs-12']
                                ) ?>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'fecha_ingreso')->widget(DatePicker::classname(), [
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

                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'fecha_envio')->widget(DatePicker::classname(), [
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

                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'client')->dropDownList($model->getListCliente(), [
                                    'prompt' => 'Seleccionar Cliente',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                ]) ?>
                            </div>

                        </div>
                    </div>

                    <?php echo Yii::$app->view->renderFile('@app/views/proforma/details.php'); ?>

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

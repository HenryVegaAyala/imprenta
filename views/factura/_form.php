<?php

use app\models\FacturaDetalle;
use kartik\widgets\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Factura */
/* @var $form yii\widgets\ActiveForm */

$descripcion = "Registrar Factura";
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <?php Pjax::begin(); ?>
                <?php $form = ActiveForm::begin(
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
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'num_factura')->textInput(
                                ['class' => 'form-control col-md-7 col-xs-12'],
                                ['maxlength' => true]) ?>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'fecha_pago')->widget(DatePicker::classname(), [
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
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'client')->dropDownList($model->getListCliente(), [
                                'prompt' => 'Seleccionar Cliente',
                                'class' => 'form-control col-md-7 col-xs-12',
                            ]) ?>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php DynamicFormWidget::begin([
                            'widgetContainer' => 'dynamicform_wrapper',
                            'widgetBody' => '.container-items',
                            'widgetItem' => '.item', // required: css class
                            'limit' => 200,
                            'min' => 0,
                            'insertButton' => '.add-item',
                            'deleteButton' => '.remove-item',
                            'model' => $modelsProformaDetalle[0],
                            'formId' => 'dynamic-form',
                            'formFields' => [
                                'cantidad',
                                'descripcion',
                                'precio',
                            ],
                        ]); ?>
                        <div class="container-items">
                            <?php foreach ($modelsProformaDetalle as $i => $modelProformaDetalle) { ?>

                                <div class="container">
                                    <button type="button" class="pull-left add-item btn btn-success btn-default">
                                        <i class="fa fa-plus"></i> Agregar Producto
                                    </button>
                                </div>

                                <div class="item">
                                    <div class="pull-right"></div>
                                    <div class="clearfix"></div>
                                    <?php
                                    if (!$modelProformaDetalle->isNewRecord) {
                                        echo Html::activeHiddenInput($modelProformaDetalle, "[{$i}]id");
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <?= $form->field($modelProformaDetalle,
                                                "[{$i}]cantidad")->textInput([
                                                'maxlength' => true,
                                                'placeholder' => 'Cantidad',
                                            ])->label(false) ?>
                                        </div>

                                        <div class="col-sm-5">
                                            <?= $form->field($modelProformaDetalle,
                                                "[{$i}]descripcion")->textInput([
                                                'maxlength' => true,
                                                'placeholder' => 'Descripción',
                                            ])->label(false) ?>
                                        </div>

                                        <div class="col-sm-3">
                                            <?= $form->field($modelProformaDetalle,
                                                "[{$i}]precio")->textInput([
                                                'maxlength' => true,
                                                'placeholder' => 'Precio',
                                            ])->label(false) ?>
                                        </div>
                                        <div class="col-sm-1">
                                            <center>
                                                <button type="button" class="remove-item btn btn-danger btn-xs">
                                                    <i class="glyphicon glyphicon-minus"></i>
                                                </button>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <?php DynamicFormWidget::end(); ?>
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
            <?php ActiveForm::end(); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
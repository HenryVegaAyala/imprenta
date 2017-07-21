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
                        'id' => 'dynamic-form',
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'validateOnChange' => false,
                        'method' => 'post',
                        'options' => [
                            'class' => 'form-horizontal form-label-left',
                            'data-pjax' => true,
                        ],
                    ]
                ); ?>
                <span class="section"><?php echo Html::encode($descripcion) ?></span>
                <div class="row">
                    <div class="item form-group">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'num_factura')->textInput(
                                ['maxlength' => 12, 'class' => 'form-control col-md-7 col-xs-12'])
                            ?>
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
                                'onchange' => "dataCliente(this.value);",
                            ]) ?>
                        </div>
                    </div>

                    <div class="container-fluid" id="contenedorCliente">
                        <legend>Datos del Cliente</legend>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>Nombre de la Compañia</label>
                                <input type="text" id="nameCompany" class="form-control input-sm text-border"/>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>N° de RUC</label>
                                <input type="text" id="ruc" class="form-control input-sm text-border"/>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>Razón Social</label>
                                <input type="text" id="businessName" class="form-control input-sm text-border"/>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>Dirección Fiscal</label>
                                <input type="text" id="fiscalAddress" class="form-control input-sm text-border"/>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid" id="line">
                        <legend></legend>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php DynamicFormWidget::begin([
                            'widgetContainer' => 'dynamicform_wrapper',
                            'widgetBody' => '.container-items',
                            'widgetItem' => '.item',
                            'limit' => 50,
                            'min' => 0,
                            'insertButton' => '.add-item',
                            'deleteButton' => '.remove-item',
                            'model' => $modelsFacturaDetalle[0],
                            'formId' => 'dynamic-form',
                            'formFields' => [
                                'cantidad',
                                'descripcion',
                                'precio',
                                'total',
                            ],
                        ]); ?>

                        <div class="container-items">
                            <table class="table table-bordered table-striped table-responsive">
                                <th class="col-sm-2">Cantidad</th>
                                <th class="col-sm-5">Descripción</th>
                                <th class="col-sm-2">Precio</th>
                                <th class="col-sm-2">Total</th>
                                <th class="col-sm-1">
                                    <div class="text-center" style="width: 90px;">
                                        <button type="button" id="addItem"
                                                class="pull-center add-item btn btn-success btn-xs">
                                            <span class="fa fa-plus"> <strong>Agregar</strong></span>
                                        </button>
                                    </div>
                                </th>
                            </table>
                            <?php foreach ($modelsFacturaDetalle as $i => $modelDetalle) { ?>
                                <div class="item">
                                    <div class="pull-right"></div>
                                    <div class="clearfix"></div>
                                    <?php
                                    if (!$modelDetalle->isNewRecord) {
                                        echo Html::activeHiddenInput($modelDetalle, "[{$i}]id");
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <?= $form->field($modelDetalle,
                                                "[{$i}]cantidad")->textInput([
                                                'maxlength' => true,
                                                'placeholder' => 'Cantidad',
                                                'onchange' => 'calcular()',
                                                'onkeyup' => 'calcular()',
                                                'name' => 'cantidad[]',
                                            ])->label(false) ?>
                                        </div>

                                        <div class="col-sm-5">
                                            <?= $form->field($modelDetalle,
                                                "[{$i}]descripcion")->textInput([
                                                'maxlength' => true,
                                                'placeholder' => 'Descripción',
                                                'name' => 'descripcion[]',
                                            ])->label(false) ?>
                                        </div>

                                        <div class="col-sm-2">
                                            <?= $form->field($modelDetalle,
                                                "[{$i}]precio")->textInput([
                                                'maxlength' => true,
                                                'placeholder' => 'Precio',
                                                'onchange' => 'calcular()',
                                                'onkeyup' => 'calcular()',
                                                'onkeypress' => 'addField()',
                                                'name' => 'precio[]',
                                            ])->label(false) ?>
                                        </div>

                                        <div class="col-sm-2">
                                            <?= $form->field($modelDetalle,
                                                "[{$i}]total")->textInput([
                                                'maxlength' => true,
                                                'readonly' => true,
                                                'placeholder' => 'Total',
                                                'name' => 'total[]',
                                            ])->label(false) ?>
                                        </div>

                                        <div class="col-sm-1">
                                            <div class="text-center" style="width: 90px;">
                                                <button type="button"
                                                        class="pull-center remove-item btn btn-danger btn-xs">
                                                    <i class="glyphicon glyphicon-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <?php DynamicFormWidget::end(); ?>
                    </div>
                </div>

                <div class="col-md-3 col-sm-12 col-xs-12" style="float: right">
                    <label class="control-label col-md-3 col-sm-6 col-xs-6">SubTotal</label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'monto_subtotal')->textInput(
                            [
                                'placeholder' => 'SubTotal',
                                'class' => 'form-control col-md-6 col-xs-6 text-border-total',
                            ]
                        )->label(false) ?>
                    </div>

                    <label class="control-label col-md-3 col-sm-6 col-xs-6">I.G.V.</label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'monto_igv')->textInput(
                            ['placeholder' => 'I.G.V', 'class' => 'form-control col-md-6 col-xs-6 text-border-total']
                        )->label(false) ?>
                    </div>

                    <label class="control-label col-md-3 col-sm-6 col-xs-6">Total</label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'monto_total')->textInput(
                            ['placeholder' => 'Total', 'class' => 'form-control col-md-6 col-xs-6 text-border-total']
                        )->label(false) ?>
                    </div>
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <center>
                    <div class="col-md-6 col-md-offset-3">
                        <?= Html::submitButton('<i class="fa fa-floppy-o fa-lg"></i> ' . ' Guardar',
                            ['class' => 'btn btn-success']) ?>
                        <?= Html::resetButton('<i class="fa fa-times fa-lg"></i> ' . ' Cancelar',
                            ['class' => 'btn btn-primary', 'id' => 'cancelar']) ?>
                    </div>
                </center>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
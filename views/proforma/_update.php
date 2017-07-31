<?php

use kartik\widgets\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelProforma app\models\Proforma */
/* @var $modelsProformaDetalle app\models\ProformaDetalle */
/* @var $form yii\widgets\ActiveForm */
$descripcion = "Modificar Proforma";
?>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
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
        <div class="x_panel">
            <div class="x_content">
                <span class="section"><?php echo Html::encode($descripcion) ?></span>
                <div class="row">
                    <div class="item form-group">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <?= $form->field($modelProforma, 'num_proforma')->textInput(
                                [
                                    'maxlength' => 12,
                                    'disabled' => true,
                                    'onkeyup' => "validateProforma(this.value);",
                                ],
                                [
                                    'class' => 'form-control col-md-7 col-xs-12',
                                ]
                            ) ?>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <?= $form->field($modelProforma, 'fecha_ingreso')->widget(DatePicker::classname(), [
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
                            <?= $form->field($modelProforma, 'fecha_envio')->widget(DatePicker::classname(), [
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
                            <?= $form->field($modelProforma,
                                'cliente_id')->dropDownList($modelProforma->getListCliente(), [
                                'prompt' => 'Seleccionar Cliente',
                                'disabled' => true,
                                'class' => 'form-control col-md-7 col-xs-12',
                                'onchange' => "dataClienteUpdate(this.value);",
                            ]) ?>
                        </div>
                    </div>

                    <div class="container-fluid" id="contenedorClienteUpdate">
                        <legend>Datos del Cliente</legend>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>Nombre de la Compañia</label>
                                <?= $form->field($modelProforma, 'nameCompany')->textInput(
                                    ['class' => 'form-control input-sm text-border'])->label(false) ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>N° de RUC</label>
                                <?= $form->field($modelProforma, 'ruc')->textInput(
                                    ['class' => 'form-control input-sm text-border'])->label(false) ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>Razón Social</label>
                                <?= $form->field($modelProforma, 'businessName')->textInput(
                                    ['class' => 'form-control input-sm text-border'])->label(false) ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>Dirección Fiscal</label>
                                <?= $form->field($modelProforma, 'fiscalAddress')->textInput(
                                    ['class' => 'form-control input-sm text-border'])->label(false) ?>
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
                            'model' => $modelsProformaDetalle[0],
                            'formId' => 'dynamic-form',
                            'formFields' => [
                                'cantidad',
                                'descripcion',
                                'precio',
                                'total',
                            ],
                        ]); ?>
                        <button type="button" id="addItem"
                                class="pull-center add-item btn btn-success btn-sm">
                            <i class="fa fa-plus"> <strong>Agregar Productos</strong></i>
                        </button>
                        <div class="container-items">
                            <table class="table table-bordered table-striped table-responsive">
                                <th class="col-sm-2 col-xs-2">Cantidad</th>
                                <th class="col-sm-5 col-xs-5">Descripción</th>
                                <th class="col-sm-2 col-xs-2">Precio</th>
                                <th class="col-sm-2 col-xs-2">Total</th>
                                <th class="col-sm-1 col-xs-1"></th>
                            </table>
                            <?php foreach ($modelsProformaDetalle as $i => $modelProformaDetalle) { ?>
                                <div class="item">
                                    <div class="pull-right"></div>
                                    <div class="clearfix"></div>
                                    <?php
                                    if (!$modelProformaDetalle->isNewRecord) {
                                        echo Html::activeHiddenInput($modelProformaDetalle, "[{$i}]id");
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-2 col-xs-2">
                                            <?= $form->field($modelProformaDetalle,
                                                "[{$i}]cantidad")->textInput([
                                                'maxlength' => true,
                                                'placeholder' => 'Cantidad',
                                                'onchange' => 'calcular()',
                                                'onkeyup' => 'calcular()',
                                                'name' => 'cantidad[]',
                                            ])->label(false) ?>
                                        </div>

                                        <div class="col-sm-5 col-xs-4">
                                            <?= $form->field($modelProformaDetalle,
                                                "[{$i}]descripcion")->textInput([
                                                'maxlength' => true,
                                                'placeholder' => 'Descripción',
                                                'name' => 'descripcion[]',
                                            ])->label(false) ?>
                                        </div>

                                        <div class="col-sm-2 col-xs-2">
                                            <?= $form->field($modelProformaDetalle,
                                                "[{$i}]precio")->textInput([
                                                'maxlength' => true,
                                                'placeholder' => 'Precio',
                                                'onchange' => 'calcular()',
                                                'onkeyup' => 'calcular()',
                                                'onkeypress' => 'addField()',
                                                'name' => 'precio[]',
                                            ])->label(false) ?>
                                        </div>

                                        <div class="col-sm-2 col-xs-2">
                                            <?= $form->field($modelProformaDetalle,
                                                "[{$i}]total")->textInput([
                                                'maxlength' => true,
                                                'readonly' => true,
                                                'placeholder' => 'Total',
                                                'name' => 'total[]',
                                            ])->label(false) ?>
                                        </div>

                                        <div class="col-sm-1 col-xs-2">
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
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12" style="float: right">
                        <label class="control-label col-md-3 col-sm-6 col-xs-6">SubTotal</label>
                        <div class="col-md-9 col-sm-6 col-xs-12">
                            <?= $form->field($modelProforma, 'monto_subtotal')->textInput(
                                [
                                    'placeholder' => 'SubTotal',
                                    'class' => 'form-control col-md-6 col-xs-6 text-border-total',
                                ]
                            )->label(false) ?>
                        </div>

                        <label class="control-label col-md-3 col-sm-6 col-xs-6">I.G.V.</label>
                        <div class="col-md-9 col-sm-6 col-xs-12">
                            <?= $form->field($modelProforma, 'monto_igv')->textInput(
                                [
                                    'placeholder' => 'I.G.V',
                                    'class' => 'form-control col-md-6 col-xs-6 text-border-total',
                                ]
                            )->label(false) ?>
                        </div>

                        <label class="control-label col-md-3 col-sm-6 col-xs-6">Total</label>
                        <div class="col-md-9 col-sm-6 col-xs-12">
                            <?= $form->field($modelProforma, 'monto_total')->textInput(
                                [
                                    'placeholder' => 'Total',
                                    'class' => 'form-control col-md-6 col-xs-6 text-border-total',
                                ]
                            )->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <center>
                    <div class="col-md-6 col-xs-12 col-md-offset-3">
                        <?= Html::submitButton('<i class="fa fa-floppy-o fa-lg"></i> ' . ' Guardar',
                            ['class' => 'btn btn-success', 'id' => 'btnGuardarProforma']) ?>
                        <?= Html::a("<i class=\"fa fa-times fa-lg\" aria-hidden=\"true\"></i> Cancelar", ['index'],
                            ['class' => 'btn btn-primary', 'id' => 'cancelar', 'onclick' => "inactiveProforma()"]) ?>
                    </div>
                </center>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
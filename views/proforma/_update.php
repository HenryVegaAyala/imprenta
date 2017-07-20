<?php

use app\models\Cliente;
use kartik\widgets\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $modelProforma app\models\Proforma */
/* @var $modelsProformaDetalle app\models\ProformaDetalle */
/* @var $form yii\widgets\ActiveForm */
$descripcion = "Registrar Proforma";
?>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <?php //Pjax::begin(); ?>
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
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <?= $form->field($modelProforma, 'num_proforma')->textInput(
                                ['maxlength' => 12, 'readonly' => 'readonly'],
                                ['class' => 'form-control col-md-7 col-xs-12']
                            ) ?>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <?= $form->field($modelProforma, 'fecha_ingreso')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => ''],
                                'value' => date('d-M-Y'),
                                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                'disabled' => true,
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
                                    'readonly' => 'readonly',
                                ],
                            ]);
                            ?>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <?= $form->field($modelProforma, 'client')->dropDownList($modelProforma->getListCliente(), [
                                'prompt' => 'Seleccionar Cliente',
                                'class' => 'form-control col-md-7 col-xs-12',
                                'onchange' => "dataCliente(this.value);",
                                'readonly' => 'readonly',
                            ]) ?>
                        </div>
                    </div>

                    <?php
                    $cliente = new Cliente();
                    $detalle = $cliente->infoCliente($modelProforma['client']);
                    foreach ($detalle as $item) { ?>
                        <div class="container-fluid">
                            <legend>Datos del Cliente</legend>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-6 col-md-3">
                                    <label>Nombre de la Compañia</label>
                                    <input type="text" value="<?= $item['desc_cliente'] ?>" id="nameCompany"
                                           class="form-control input-sm text-border" readonly/>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3">
                                    <label>N° de RUC</label>
                                    <input type="text" value="<?= $item['numero_ruc'] ?>" id="ruc"
                                           class="form-control input-sm text-border" readonly/>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3">
                                    <label>Razón Social</label>
                                    <input type="text" value="<?= $item['razon_social'] ?>" id="businessName"
                                           class="form-control input-sm text-border" readonly/>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3">
                                    <label>Dirección Fiscal</label>
                                    <input type="text"
                                           value="<?= $item['referencia'] . ' ' . $item['distrito'] . ' ' . $item['provincia'] . ' ' . $item['departamento'] ?>"
                                           id="fiscalAddress" class="form-control input-sm text-border" readonly/>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="container-fluid" id="line">
                        <legend></legend>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="container-items">
                            <table class="table table-bordered table-striped table-responsive">
                                <th class="col-sm-2">Cantidad</th>
                                <th class="col-sm-6">Descripción</th>
                                <th class="col-sm-2">Precio</th>
                                <th class="col-sm-2">Total</th>
                            </table>
                        </div>
                        <div>
                            <?php
                            $modelsProformaDetalles = new \app\models\ProformaDetalle();
                            $modelsProformaDetalle = $modelsProformaDetalles->detailsProforma($modelProforma['id']);
                            foreach ($modelsProformaDetalle AS $modelsProformaDetalles) { ?>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group field-proformadetalle-0-cantidad required">

                                            <input type="text" readonly
                                                   value="<?= $modelsProformaDetalles['cantidad'] ?> "
                                                   id="proformadetalle-0-cantidad" class="form-control"
                                                   name="cantidad[]" placeholder="Cantidad" onchange="calcular()"
                                                   onkeyup="calcular()">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group field-proformadetalle-0-descripcion required">

                                            <input type="text" readonly
                                                   value="<?= $modelsProformaDetalles['descripcion'] ?> "
                                                   id="proformadetalle-0-descripcion" class="form-control"
                                                   name="descripcion[]" maxlength="250" placeholder="Descripción">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group field-proformadetalle-0-precio required">

                                            <input type="text" readonly
                                                   value="<?= $modelsProformaDetalles['precio'] ?> "
                                                   id="proformadetalle-0-precio" class="form-control" name="precio[]"
                                                   placeholder="Precio" onchange="calcular()" onkeyup="calcular()"
                                                   onkeypress="addField()">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group field-proformadetalle-0-total required">

                                            <input type="text" readonly
                                                   value="<?= $modelsProformaDetalles['monto_total'] ?> "
                                                   id="proformadetalle-0-total" class="form-control" name="total[]"
                                                   readonly="" placeholder="Total">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
                $modelsProformaDetalles = new \app\models\ProformaDetalle();
                $modelsProformaDetalle = $modelsProformaDetalles->Proforma($modelProforma['id']);
                foreach ($modelsProformaDetalle AS $modelsProformaDetalles) { ?>
                    <div class="col-md-3 col-sm-12 col-xs-12" style="float: right">
                        <label class="control-label col-md-3 col-sm-6 col-xs-6">SubTotal</label>
                        <div class="col-md-9 col-sm-6 col-xs-12">
                            <div class="form-group field-proforma-monto_subtotal required">

                                <input type="text" id="proforma-monto_subtotal"
                                       value="<?= $modelsProformaDetalles['monto_subtotal'] ?>"
                                       class="form-control col-md-6 col-xs-6 text-border-total"
                                       name="Proforma[monto_subtotal]" placeholder="SubTotal" aria-required="true"
                                       readonly="">

                                <div class="help-block"></div>
                            </div>
                        </div>

                        <label class="control-label col-md-3 col-sm-6 col-xs-6">I.G.V.</label>
                        <div class="col-md-9 col-sm-6 col-xs-12">
                            <div class="form-group field-proforma-monto_igv required">

                                <input type="text" id="proforma-monto_igv"
                                       value="<?= $modelsProformaDetalles['monto_igv'] ?>"
                                       class="form-control col-md-6 col-xs-6 text-border-total"
                                       name="Proforma[monto_igv]"
                                       placeholder="I.G.V" aria-required="true" readonly="">

                                <div class="help-block"></div>
                            </div>
                        </div>

                        <label class="control-label col-md-3 col-sm-6 col-xs-6">Total</label>
                        <div class="col-md-9 col-sm-6 col-xs-12">
                            <div class="form-group field-proforma-monto_total required">

                                <input type="text" id="proforma-monto_total"
                                       value="<?= $modelsProformaDetalles['monto_total'] ?>"
                                       class="form-control col-md-6 col-xs-6 text-border-total"
                                       name="Proforma[monto_total]"
                                       placeholder="Total" aria-required="true" readonly="">

                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
        <?php //Pjax::end(); ?>
    </div>
</div>
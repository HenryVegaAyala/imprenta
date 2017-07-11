<?php

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
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <?= $form->field($modelProforma, 'num_proforma')->textInput(
                                ['maxlength' => 12],
                                ['class' => 'form-control col-md-7 col-xs-12']
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
                            <?= $form->field($modelProforma, 'client')->dropDownList($modelProforma->getListCliente(), [
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
                            <table class="table table-bordered table-striped">
                                <th class="col-sm-2">Cantidad</th>
                                <th class="col-sm-5">Descripción</th>
                                <th class="col-sm-2">Precio</th>
                                <th class="col-sm-2">Total</th>
                                <th class="col-sm-1">
                                    <div class="text-center" style="width: 90px;">
                                        <button type="button" class="pull-center add-item btn btn-success btn-xs">
                                            <span class="fa fa-plus"> Agregar</span>
                                        </button>
                                    </div>
                                </th>
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
                                            <div class="col-sm-2">
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

                                            <div class="col-sm-2">
                                                <?= $form->field($modelProformaDetalle,
                                                    "[{$i}]precio")->textInput([
                                                    'maxlength' => true,
                                                    'placeholder' => 'Precio',
                                                ])->label(false) ?>
                                            </div>

                                            <div class="col-sm-2">
                                                <?= $form->field($modelProformaDetalle,
                                                    "[{$i}]total")->textInput([
                                                    'maxlength' => true,
                                                    'placeholder' => 'Total',
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
                            </table>
                        </div>

                        <?php DynamicFormWidget::end(); ?>
                    </div>
                </div>

            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <center>
                    <div class="col-md-6 col-md-offset-3">
                        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                        <?= Html::resetButton('Cancelar', ['class' => 'btn btn-primary']) ?>
                    </div>
                </center>
            </div>
            <?php ActiveForm::end(); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
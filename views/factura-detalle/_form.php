<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\FacturaDetalle */
/* @var $form yii\widgets\ActiveForm */

$unique = uniqid();

if ($model->primaryKey) {
    $removeAttr = 'data-dynamic-relation-remove-route="' . Url::toRoute(['delete', 'id' => $model->primaryKey]) . '"';
    $frag = "FacturaDetalle[{$model->primaryKey}]";
} else {
    $removeAttr = "";
    $frag = "FacturaDetalle[new][$unique]";
}
?>

<div class="Factura-detalle-form" <?php echo $removeAttr; ?> >
    <div class="row">

        <div class="col-sm-1">
            <div class="form-group field-Factura-Cantidad">
                <?= Html::input('text', $frag . '[cantidad]', $model->cantidad,
                    ['id' => 'Facturadetalle-cantidad', 'class' => 'form-control']) ?>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="col-sm-1">
            <div class="form-group field-Factura-Precio">
                <?= Html::input('text', $frag . '[precio]', $model->precio,
                    ['id' => 'Facturadetalle-precio', 'class' => 'form-control']) ?>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="col-sm-7">
            <div class="form-group field-Factura-Descripcion">
                <?= Html::input('text', $frag . '[descripcion]', $model->descripcion,
                    ['id' => 'Facturadetalle-descripcion', 'class' => 'form-control']) ?>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group field-Factura-Total">
                <?= Html::input('text', $frag . '[total]', $model->total,
                    ['id' => 'Facturadetalle-descripcion', 'class' => 'form-control']) ?>
                <div class="help-block"></div>
            </div>
        </div>

    </div>
</div>

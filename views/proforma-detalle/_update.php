<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\ProformaDetalle */
/* @var $modelPD app\models\ProformaDetalle */
/* @var $form yii\widgets\ActiveForm */

$uniq = uniqid();

if ($model->primaryKey) {
    $removeAttr = 'data-dynamic-relation-remove-route="' . Url::toRoute(['delete', 'id' => $modelPD->primaryKey]) . '"';
    $frag = "proformadetalle[new][" . rand(1, 9999999999) . "]";
} else {
    $removeAttr = "";
    $frag = "proformadetalle[new][" . rand(1, 9999999999) . "]";
}
?>

<div class="proforma-detalle-form" <?php echo $removeAttr; ?> >
    <div class="row">

        <div class="col-sm-1">
            <div class="form-group field-beneficiario-Cantidad">
                <?= Html::input('text', $frag . '[cantidad]', $model->cantidad,
                    ['id' => 'proformadetalle-cantidad', 'class' => 'form-control']) ?>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="col-sm-1">
            <div class="form-group field-beneficiario-Precio">
                <?= Html::input('text', $frag . '[precio]', $model->precio,
                    ['id' => 'proformadetalle-precio', 'class' => 'form-control']) ?>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="col-sm-7">
            <div class="form-group field-beneficiario-Descripcion">
                <?= Html::input('text', $frag . '[descripcion]', $model->descripcion,
                    ['id' => 'proformadetalle-descripcion', 'class' => 'form-control']) ?>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group field-beneficiario-Total">
                <?= Html::input('text', $frag . '[total]', $model->total,
                    ['id' => 'proformadetalle-descripcion', 'class' => 'form-control']) ?>
                <div class="help-block"></div>
            </div>
        </div>

    </div>
</div>

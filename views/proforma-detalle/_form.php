<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\ProformaDetalle */
/* @var $form yii\widgets\ActiveForm */

$unique = uniqid();

if ($model->primaryKey) {
    $removeAttr = 'data-dynamic-relation-remove-route="' . Url::toRoute(['delete', 'id' => $model->primaryKey]) . '"';
    $frag = "ProformaDetalle[{$model->primaryKey}]";
} else {
    $removeAttr = "";
    $frag = "ProformaDetalle[new][$unique]";
}
?>

<div class="proforma-detalle-form" <?php echo $removeAttr; ?> >
    <div class="row">

        <div class="col-sm-1">
            <div class="form-group field-beneficiario-Nombre">
                <?= Html::input('text', $frag . '[cantidad]', $model->cantidad,
                    ['id' => 'proformadetalle-cantidad', 'class' => 'form-control']) ?>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="col-sm-1">
            <div class="form-group field-beneficiario-Nombre">
                <?= Html::input('text', $frag . '[precio]', $model->precio,
                    ['id' => 'proformadetalle-precio', 'class' => 'form-control']) ?>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="col-sm-9">
            <div class="form-group field-beneficiario-Nombre">
                <?= Html::input('text', $frag . '[descripcion]', $model->descripcion,
                    ['id' => 'proformadetalle-descripcion', 'class' => 'form-control']) ?>
                <div class="help-block"></div>
            </div>
        </div>

    </div>
</div>

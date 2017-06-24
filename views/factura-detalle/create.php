<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FacturaDetalle */

$this->title = 'Create Factura Detalle';
$this->params['breadcrumbs'][] = ['label' => 'Factura Detalles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proforma-detalle-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

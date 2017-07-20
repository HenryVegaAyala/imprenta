<?php

/* @var $this yii\web\View */
/* @var $model app\models\Proforma */

$this->title = 'Branusac - Registrar Nueva Proforma';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="right_col" role="main">
    <?= $this->render('_form', [
        'modelProforma' => $modelProforma,
        'modelsProformaDetalle' => $modelsProformaDetalle,
    ]) ?>
</div>

<?php

/* @var $this yii\web\View */
/* @var $model app\models\Proforma */

$this->title = 'Branusac - Actualizar Proforma';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="right_col" role="main">
    <?= $this->render('_update', [
        'modelProforma' => $modelProforma,
        'modelsProformaDetalle' => $modelsProformaDetalle,
    ]) ?>
</div>

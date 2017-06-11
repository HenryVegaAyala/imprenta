<?php

/* @var $this yii\web\View */
/* @var $model app\models\Factura */

$this->title = 'Branusac - Crear Nueva Factura';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="right_col" role="main">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

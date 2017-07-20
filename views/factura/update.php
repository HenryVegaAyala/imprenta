<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Factura */

$this->title = 'Branusac - Actualizar Factura';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="right_col" role="main">
    <?= $this->render('_update', [
        'model' => $model,
        'models' => $models,
    ]) ?>
</div>

<?php

/* @var $this yii\web\View */
/* @var $model app\models\Reporte */

$this->title = 'Branusac - Reporte';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="right_col" role="main">
    <?= $this->render('_reporte', [
        'model' => $model,
    ]) ?>
</div>

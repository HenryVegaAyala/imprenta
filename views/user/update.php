<?php


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Branusac - Actualizar Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="right_col" role="main">
    <?= $this->render('_update', [
        'model' => $model,
    ]) ?>
</div>

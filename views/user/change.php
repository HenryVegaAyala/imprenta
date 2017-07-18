<?php

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Branusac - Actualizar Perfil';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="right_col" role="main">
    <?= $this->render('_changePassword', [
        'model' => $model,
    ]) ?>
</div>

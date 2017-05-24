<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="right_col" role="main">
    <div class="container-fluid">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'apellido',
            'telefono',
            'dni',
            // 'correo',
            // 'privilegio',
            // 'contrasena',
            // 'contrasena_desc',
            // 'authKey',
            // 'accessToken',
            // 'fecha_digitada',
            // 'fecha_modificada',
            // 'fecha_eliminada',
            // 'usuario_digitado',
            // 'usuario_modificado',
            // 'usuario_eliminado',
            // 'ip',
            // 'host',
            // 'estado',
            // 'genero',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

    </div>
</div>

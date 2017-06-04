<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lista de Usuario';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="right_col" role="main">
    <div class="container-fluid">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'nombre',
                'apellido',
                'correo',
                'privilegio',
                'estado',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete} ',
                    'header' => 'Detalle',
                    'headerOptions' => ['class' => 'itemHide'],
                    'contentOptions' => ['class' => 'itemHide'],
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a('<span class="fa fa-pencil-square-o fa-lg"></span>',
                                Yii::$app->urlManager->createUrl(['actualizar-usuario/' . $model->id]),
                                ['title' => Yii::t('yii', 'Actualizar'),]
                            );
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                ['eliminar-usuario/' . $model['id']], [
                                    'title' => Yii::t('app', 'Eliminar'),
                                    'data-confirm' => Yii::t('app', '¿Esta Seguro de eliminar este 
                                    usuario?'),
                                    'data-method' => 'post',
                                ]);
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProformaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Branusac - Lista de Proformas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="right_col" role="main">
    <div class="container-fluid">
        <div class="table table-striped table-responsive jambo_table bulk_action">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= $this->title ?></h3>
                </div>

                <p class="note"></p>

                <div class="fieldset">
                    <div class="container-fluid">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                'num_proforma',
                                'fecha_ingreso',
                                'fecha_envio',
                                'monto_total',
                                'estado',

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Detalle',
                                    'template' => ' {update} {delete} ',
                                    'headerOptions' => ['class' => 'itemHide'],
                                    'contentOptions' => ['class' => 'itemHide'],
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            return Html::a('<span class="fa fa-pencil-square-o fa-lg"></span>',
                                                Yii::$app->urlManager->createUrl(['actualizar-proforma/' . $model->id]),
                                                ['title' => Yii::t('yii', 'Actualizar'),]
                                            );
                                        },
                                        'delete' => function ($url, $model) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                                ['eliminar-usuario/' . $model['id']], [
                                                    'title' => Yii::t('app', 'Eliminar'),
                                                    'data-confirm' => Yii::t('app',
                                                        '¿Esta Seguro de eliminar esta proforma??'),
                                                    'data-method' => 'post',
                                                ]);
                                        },
                                    ],
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>

                <div class="panel-footer container-fluid">
                    <div class="col-sm-12">
                        <?= Html::a('<i class="fa fa-refresh" aria-hidden="true"></i> Refrescar', ['index'],
                            ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


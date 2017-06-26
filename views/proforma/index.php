<?php

use app\models\Proforma;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProformaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Branusac - Lista de Proformas';
$this->params['breadcrumbs'][] = $this->title;
$proforma = new Proforma();
?>
<div class="right_col" role="main">
    <div class="clearfix"></div>
        <div class="x_panel">
            <div class="x_content">
                <?php Pjax::begin([
                    'timeout' => false,
                    'enablePushState' => false,
                    'clientOptions' => ['method' => 'POST'],
                ]); ?>
                <div class="table table-striped table-responsive jambo_table bulk_action">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?= $this->title ?></h3>
                        </div>
                        <p class="note"></p>
                            <div class="container-fluid">
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],

                                        'num_proforma',
                                        [
                                            'attribute' => 'fecha_ingreso',
                                            'label' => 'Fecha de Ingreso',
                                            'value' => function ($data) {
                                                return date('d-m-Y', strtotime($data->fecha_ingreso));
                                            },
                                        ],
                                        [
                                            'attribute' => 'fecha_envio',
                                            'label' => 'Fecha de Envio',
                                            'value' => function ($data) {
                                                return date('d-m-Y', strtotime($data->fecha_envio));
                                            },
                                        ],
                                        [
                                            'attribute' => 'monto_total',
                                            'label' => 'Monto Total',
                                            'value' => function ($data) {
                                                if (empty($data->monto_total)) {
                                                    return 'S/. 0.00';
                                                } else {
                                                    return $data->monto_total;
                                                }
                                            },
                                        ],
                                        [
                                            'attribute' => 'estado',
                                            'label' => 'Estado',
                                            'filter' => $proforma->status(),
                                            'value' => function ($data) {
                                                $proforma = new Proforma();
                                                $status = $proforma->getStatus($data->estado);

                                                return $status;
                                            },
                                        ],
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

                            <div class="panel-footer container-fluid">
                                <div class="col-sm-12">
                                    <?= Html::a('<i class="fa fa-refresh" aria-hidden="true"></i> Refrescar', ['index'],
                                        ['class' => 'btn btn-primary']) ?>
                                </div>
                            </div>
                        <?php Pjax::end() ?>
                    </div>
                </div>
            </div>
    </div>
</div>


<?php

use app\models\Proforma;
use kartik\widgets\Select2;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProformaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $form yii\widgets\ActiveForm */

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
                                [
                                    'attribute' => 'num_proforma',
                                    'label' => 'N° de Proforma',
                                    'value' => function ($data) {
                                        return $data->num_proforma;
                                    },
                                ],
                                [
                                    'attribute' => 'cliente_id',
                                    'label' => 'Cliente',
                                    'filter' => Select2::widget([
                                        'name' => 'ProformaSearch[cliente_id]',
                                        'data' => $proforma->listCliente(),
                                        'options' => [
                                            'placeholder' => 'Lista de Clientes',
                                        ],
                                    ]),
                                    'value' => function ($data) {
                                        return $data->cliente_name;
                                    },
                                ],
                                [
                                    'attribute' => 'fecha_ingreso',
                                    'label' => 'Fecha de Ingreso',
                                    'filter' => DateRangePicker::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'fecha_ingreso',
                                        'convertFormat' => true,
                                        'language' => 'es',
                                        'pluginOptions' => [
                                            'locale' => [
                                                'format' => 'Y-m-d',
                                            ],
                                        ],
                                    ]),
                                    'value' => function ($data) {
                                        return $data->fecha_ingreso;
                                    },
                                ],
                                [
                                    'attribute' => 'fecha_envio',
                                    'label' => 'Fecha de Envio',
                                    'filter' => DateRangePicker::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'fecha_envio',
                                        'convertFormat' => true,
                                        'pluginOptions' => [
                                            'locale' => [
                                                'format' => 'Y-m-d',
                                            ],
                                        ],
                                    ]),
                                    'value' => function ($data) {
                                        return $data->fecha_envio;
                                    },
                                ],
                                [
                                    'attribute' => 'monto_total',
                                    'label' => 'Monto Total',
                                    'value' => function ($data) {
                                        return 'S/. ' . $data->monto_total;
                                    },
                                ],
                                [
                                    'attribute' => 'estado',
                                    'label' => 'Estado',
                                    'filter' => $proforma->status(),
                                    'value' => function ($data) {
                                        return $data->proforma_estado;
                                    },
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Cuadro de Actividades',
                                    'options' => ['style' => 'width:170px;'],
                                    'template' => '{detalle} / {update} / {delete} / {factura} / {correo} / {reporte} ',
                                    'headerOptions' => ['class' => 'itemHide'],
                                    'contentOptions' => ['class' => 'itemHide'],
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            return Html::a('<span class="fa fa-pencil fa-lg"></span>',
                                                Yii::$app->urlManager->createUrl(['actualizar-proforma/' . $model->id]),
                                                ['title' => Yii::t('yii', 'Actualizar'),]
                                            );
                                        },
                                        'delete' => function ($url, $model) {
                                            return Html::a('<span class="fa fa-trash-o fa-lg"></span>',
                                                ['eliminar-usuario/' . $model['id']], [
                                                    'title' => Yii::t('app', 'Eliminar'),
                                                    'data-confirm' => Yii::t('app',
                                                        '¿Esta Seguro de eliminar esta Proforma?'),
                                                    'data-method' => 'post',
                                                ]);
                                        },
                                        'correo' => function ($url, $model) {
                                            return "<span class=\"fa fa-envelope fa-lg\"></span>";
                                        },
                                        'factura' => function ($url, $model) {
                                            return "<span class=\"fa fa-cog fa-lg\"></span>";
                                        },
                                        'reporte' => function ($url, $model) {
                                            return "<span class=\"fa fa-file-pdf-o fa-lg\"></span>";
                                        },
                                        'detalle' => function ($url, $model) {
                                            return "<span class=\"fa fa-eye fa-lg\"></span>";
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
                </div>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
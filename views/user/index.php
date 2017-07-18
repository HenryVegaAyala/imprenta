<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Branusac - Listas de Usuario';
$this->params['breadcrumbs'][] = $this->title;
$usuario = new User();
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
                                'nombre',
                                'apellido',
                                'correo',
                                [
                                    'attribute' => 'privilegio',
                                    'label' => 'Privilegio',
                                    'filter' => $usuario->rol(),
                                    'value' => function ($data) {
                                        $usuario = new User();
                                        $rol = $usuario->getRol($data->privilegio);

                                        return $rol;
                                    },
                                ],
                                [
                                    'attribute' => 'estado',
                                    'label' => 'Estado',
                                    'filter' => $usuario->status(),
                                    'value' => function ($data) {
                                        $usuario = new User();
                                        $rol = $usuario->getStatus($data->estado);

                                        return $rol;
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
                                                Yii::$app->urlManager->createUrl(['actualizar-usuario/' . $model->id]),
                                                ['title' => Yii::t('yii', 'Actualizar'),]
                                            );
                                        },
                                        'delete' => function ($url, $model) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                                ['eliminar-usuario/' . $model['id']], [
                                                    'title' => Yii::t('app', 'Eliminar'),
                                                    'data-confirm' => Yii::t('app',
                                                        '¿Esta Seguro de eliminar este usuario?'),
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
                </div>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
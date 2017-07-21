<?php

namespace app\controllers;

use app\models\Cliente;
use app\models\FacturaDetalle;
use app\models\Notificaciones;
use app\models\ProformaDetalle;
use app\models\Transaccion;
use Yii;
use app\models\Factura;
use app\models\FacturaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FacturaController implements the CRUD actions for Factura model.
 */
class FacturaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Factura models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FacturaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Factura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Factura();
        $modelsProformaDetalle = [new FacturaDetalle];
        $notificaciones = new Notificaciones();
        $cliente = new Cliente();
        $transacion = new Transaccion();

        if ($model->load(Yii::$app->request->post())) {
            $requestDayStart = Yii::$app->formatter->asDate(strtotime($model->fecha_ingreso), 'Y-MM-dd');
            $requestDaySend = Yii::$app->formatter->asDate(strtotime($model->fecha_envio), 'Y-MM-dd');
            $model->id = $model->getIdTable();
            $model->fecha_ingreso = $requestDayStart;
            $model->fecha_envio = $requestDaySend;
            $model->usuario_digitado = Yii::$app->user->identity->correo;
            $model->fecha_digitada = $this->zonaHoraria();
            $model->ip = Yii::$app->request->userIP;
            $model->host = strval(php_uname());
            $model->estado = true;
            $model->save();

            $notificaciones->titulo = 'Nueva Proforma Solicitada';
            $notificaciones->descripcion = 'Se ha creó una Profoma para el Cliente ' . $cliente->infoCliente($model->client);
            $notificaciones->creado = $this->zonaHoraria();
            $notificaciones->usuario = Yii::$app->user->identity->nombre . ' ' . Yii::$app->user->identity->apellido;
            $notificaciones->estado = true;
            $notificaciones->save();

            $transacion->proforma_id = $model->id;
            $transacion->cliente_id = $model->client;
            $transacion->estado = true;
            $transacion->save();

            $countProducts = count($_POST['cantidad']);
            $cantidad = $_POST['cantidad'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];

            for ($i = 0; $i < $countProducts; $i++) {
                if ($descripcion[$i] <> '') {
                    Yii::$app->db->createCommand()->batchInsert('proforma_detalle',
                        [
                            'proforma_id',
                            'cantidad',
                            'descripcion',
                            'precio',
                            'monto_subtotal',
                            'monto_igv',
                            'monto_total',
                            'fecha_digitada',
                            'usuario_digitado',
                        ],
                        [
                            [
                                $model->id,
                                $cantidad[$i],
                                $descripcion[$i],
                                $precio[$i],
                                (($cantidad[$i] * $precio[$i]) * 0.18),
                                (($cantidad[$i] * $precio[$i])) - (($cantidad[$i] * $precio[$i]) * 0.18),
                                (($cantidad[$i] * $precio[$i])),
                                $this->zonaHoraria(),
                                Yii::$app->user->identity->correo,
                            ],
                        ]
                    )->execute();
                }
            }
            $this->notification(1, $model->num_proforma);

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'modelProforma' => $model,
                'modelsProformaDetalle' => (empty($modelsProformaDetalle)) ? [new ProformaDetalle] : $modelsProformaDetalle,
            ]);
        }
    }

    /**
     * Updates an existing Factura model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Factura model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Factura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Factura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Factura::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace app\controllers;

use app\models\Cliente;
use app\models\Notificaciones;
use app\models\ProformaDetalle;
use app\models\Transaccion;
use Yii;
use app\models\Proforma;
use app\models\ProformaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProformaController implements the CRUD actions for Proforma model.
 */
class ProformaController extends Controller
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
     * Lists all Proforma models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProformaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }/** @noinspection PhpInconsistentReturnPointsInspection */

    /**
     * Creates a new Proforma model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Proforma();
        $modelsProformaDetalle = [new ProformaDetalle];
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
     * Updates an existing Proforma model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelProforma = $this->findModel($id);

        if ($modelProforma->load(Yii::$app->request->post())) {
            $modelProforma->save();
            $this->notification(2, $modelProforma->num_proforma);

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'modelProforma' => $modelProforma,
                'modelsProformaDetalle' => (empty($modelsProformaDetalle)) ? [new ProformaDetalle] : $modelsProformaDetalle,
            ]);
        }
    }

    /**
     * Deletes an existing Proforma model.
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
     * Finds the Proforma model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Proforma|array|\yii\db\ActiveRecord
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Proforma::find()
            ->select([
                'proforma.id AS id',
                'num_proforma',
                'fecha_ingreso',
                'fecha_envio',
                'cliente_id AS client',
                'proforma.estado AS estado',
            ])
            ->leftJoin('transaccion', 'transaccion.proforma_id = proforma.id')
            ->where(['proforma.id' => $id])
            ->one();
        if (($model) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @return false|string
     */
    public function zonaHoraria()
    {
        date_default_timezone_set('America/Lima');
        $now = date('Y-m-d h:i:s', time());

        return $now;
    }

    /** @noinspection PhpInconsistentReturnPointsInspection */

    /**
     * @param $estado
     * @param $proforma
     */
    public function notification($estado, $proforma)
    {
        switch ($estado) {
            case 1:
                $title = 'Nueva Proforma Registrada';
                $message = 'Se ha registrado la Proforma N° - ' . $proforma . ' correctamente.';
                $type = 'success';
                break;
            case 2:
                $title = 'Proforma Actualizado';
                $message = 'Se ha actualizado la Proforma N° - ' . $proforma . ' correctamente.';
                $type = 'success';
                break;
            case 3:
                $title = 'Proforma Eliminada';
                $message = 'Se ha eliminado la Proforma N° - ' . $proforma . ' correctamente.';
                $type = 'success';
                break;
            case 4:
                $title = 'Envío de Proforma al correo';
                $message = 'Se envió correctamente la proforma al correo del Cliente.';
                $type = 'info';
                break;
        }

        if (isset($type)) {
            if (isset($message)) {
                if (isset($title)) {
                    /** @noinspection PhpVoidFunctionResultUsedInspection */
                    $notification = Yii::$app->getSession()->setFlash('success', [
                        'type' => $type,
                        'duration' => 6000,
                        'icon' => 'fa fa-users',
                        'message' => $message,
                        'title' => $title,
                        'positonY' => 'top',
                        'positonX' => 'right',
                    ]);

                    return $notification;
                }
            }
        }
    }

    public function actionCliente()
    {
        $idCliente = $_POST['id'];
        $sqlStatement = "SELECT * FROM cliente WHERE id = '" . $idCliente . "' AND estado = 1";
        $commands = Yii::$app->db->createCommand($sqlStatement);
        $result = $commands->query();
        while ($row = $result->read()) {
            echo $row['desc_cliente'] . "/" . $row['numero_ruc'] . "/" . $row['razon_social'] .
                "/" . $row['referencia'] . ' ' . $row['provincia'] . ' ' . $row['departamento'];
        }
    }
}

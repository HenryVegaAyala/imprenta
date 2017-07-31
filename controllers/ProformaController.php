<?php

namespace app\controllers;

use app\models\Cliente;
use app\models\Notificaciones;
use app\models\ProformaDetalle;
use Yii;
use app\models\Proforma;
use app\models\ProformaSearch;
use yii\db\Expression;
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
    }

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
            $notificaciones->descripcion = 'Se ha creó una Proforma para el Cliente ' .
                $cliente->infoCliente($model->cliente_id);
            $notificaciones->creado = $this->zonaHoraria();
            $notificaciones->usuario = Yii::$app->user->identity->nombre . ' ' . Yii::$app->user->identity->apellido;
            $notificaciones->estado = true;
            $notificaciones->save();

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
            $this->notification(4, $model->num_proforma);

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'modelProforma' => $model,
                'modelsProformaDetalle' => (
                empty($modelsProformaDetalle)) ? [new ProformaDetalle] : $modelsProformaDetalle,
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
        $modelsProformaDetalle = [new ProformaDetalle];

        if ($modelProforma->load(Yii::$app->request->post())) {
            $date_ing = Yii::$app->formatter->asDate(strtotime($modelProforma->fecha_ingreso), 'Y-MM-dd');
            $date_send = Yii::$app->formatter->asDate(strtotime($modelProforma->fecha_envio), 'Y-MM-dd');

            $connection = Yii::$app->db;
            $connection->createCommand()
                ->update('proforma',
                    [
                        'fecha_ingreso' => $date_ing,
                        'fecha_envio' => $date_send,
                        'cliente_id' => $modelProforma->cliente_id,
                        'fecha_modificada' => $this->zonaHoraria(),
                        'usuario_modificado' => Yii::$app->user->identity->correo,
                        'ip' => Yii::$app->request->userIP,
                        'host' => strval(php_uname()),
                    ],
                    'id = :id', [':id' => $id])
                ->execute();

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'modelProforma' => $modelProforma,
                'modelsProformaDetalle' => (
                empty($modelsProformaDetalle)) ? [new ProformaDetalle] : $modelsProformaDetalle,
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
     * @return Proforma|array|\yii\db\ActiveQuery|\yii\db\ActiveRecord
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Proforma::find()
            ->select([
                'proforma.id                              AS id',
                'proforma.num_proforma                    AS num_proforma',
                'proforma.cliente_id                      AS cliente_id',
                'date_format(fecha_ingreso, \'%d-%m-%Y\') AS fecha_ingreso',
                'date_format(fecha_envio, \'%d-%m-%Y\')   AS fecha_envio',
                'monto_total                              AS monto_total',
                'monto_subtotal                           AS monto_subtotal',
                'monto_igv                                AS monto_igv',
                'cliente.desc_cliente                     AS nameCompany',
                'cliente.numero_ruc                       AS ruc',
                'cliente.razon_social                     AS businessName',
            ])
            ->addSelect([
                new Expression("
                concat(dir_fisica, ' ', distrito, ' ', provincia, ' ', departamento) AS fiscalAddress"),
            ])
            ->leftJoin('cliente', 'proforma.cliente_id = cliente.id')
            ->where('proforma.id = :id', [':id' => $id])
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
                $message = 'Se ha registrado la Proforma N° - ' . $proforma . ' Correctamente.';
                $type = 'success';
                break;
            case 2:
                $title = 'Proforma Actualizado';
                $message = 'Se ha actualizado la Proforma N° - ' . $proforma . ' Correctamente.';
                $type = 'success';
                break;
            case 3:
                $title = 'Proforma Eliminada';
                $message = 'Se ha eliminado la Proforma N° - ' . $proforma . ' Correctamente.';
                $type = 'success';
                break;
            case 4:
                $title = 'Envío de Proforma al correo';
                $message = 'Se envió correctamente la proforma al correo del Cliente.';
                $type = 'info';
                break;
            case 5:
                $title = 'El N° de Proforma ya fué Registrada';
                $message = 'La proforma N° - ' . $proforma . ' ya fue registrada anteriormente.';
                $type = 'error';
                break;
        }

        if (!empty($type) && !empty($message) && !empty($title)) {
            $notification = Yii::$app->getSession()->setFlash($type, [
                'type' => $type,
                'duration' => 6000,
                'icon' => 'fa fa-users',
                'message' => $message,
                'title' => $title,
                'positonY' => 'top',
                'positonX' => 'right',
            ]);
        }

        if (!empty($notification)) {
            return $notification;
        }
    }

    public function actionCliente()
    {
        $idCliente = $_POST['id'];
        $sqlStatement = "SELECT desc_cliente,numero_ruc,razon_social,referencia,provincia,departamento 
        FROM cliente WHERE id = :idCliente AND estado = 1";
        $commands = Yii::$app->db->createCommand($sqlStatement)->cache(3600)->bindValue(':idCliente', $idCliente);
        $result = $commands->query();
        while ($row = $result->read()) {
            echo $row['desc_cliente'] . "/" . $row['numero_ruc'] . "/" . $row['razon_social'] .
                "/" . $row['referencia'] . ' ' . $row['provincia'] . ' ' . $row['departamento'];
        }
    }

    /**
     * @return bool
     */
    public function actionSerie()
    {
        $model = new Proforma();
        $numero_proforma = $_POST['proforma'];
        $validate = $model->validateProforma($numero_proforma);

        return $validate;
    }

    /**
     * @return string
     */
    public function actionValidate()
    {
        if (!empty($_POST['fecha_ini']) && !empty($_POST['fecha_env'])) {
            $fechaIng = $_POST['fecha_ini'];
            $fechaEnv = $_POST['fecha_env'];
            $fechaIng_explode = explode("-", $fechaIng);
            $fechaEnv_explode = explode("-", $fechaEnv);
            $formatIng = $fechaIng_explode[0] . $fechaIng_explode[1] . $fechaIng_explode[2];
            $formatEnv = $fechaEnv_explode[0] . $fechaEnv_explode[1] . $fechaEnv_explode[2];

            if ($fechaIng_explode[2] > $fechaEnv_explode[2] || $formatIng > $formatEnv) {
                return ' fecha de envio ' . "/" . $this->formatDay($fechaEnv) . ',' . "/" .
                    ' debe de ser mayor a la fecha de ingreso ' . "/" .
                    $this->formatDay($fechaIng);
            }
        }
    }

    /**
     * @param $date
     * @return string
     */
    public function formatDay($date)
    {
        $month = [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
        ];
        $nowDate = explode('-', $date);

        return $nowDate[0] . ' de ' . $month[intval($nowDate[1])] . ' del ' . $nowDate[2];
    }
}

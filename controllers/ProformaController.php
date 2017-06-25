<?php

namespace app\controllers;

use app\models\ProformaDetalle;
use app\models\Transaccion;
use synatree\dynamicrelations\DynamicRelations;
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        $transaccion = new Transaccion();

        if ($model->load(Yii::$app->request->post())) {
            $model->id = $model->getIdTable();
            $model->fecha_ingreso = Yii::$app->formatter->asDate(strtotime($model->fecha_ingreso), 'Y-MM-dd');
            $model->fecha_envio = Yii::$app->formatter->asDate(strtotime($model->fecha_envio), 'Y-MM-dd');
            $model->fecha_digitada = $this->zonaHoraria();
            /** @noinspection PhpUndefinedFieldInspection */
            $model->usuario_digitado = Yii::$app->user->identity->correo;
            $model->ip = Yii::$app->request->userIP;
            $model->host = strval(php_uname());
            $model->estado = true;
            $model->save();
            DynamicRelations::relate($model, 'proformaDetalles', Yii::$app->request->post(), 'ProformaDetalle',
                ProformaDetalle::className());

            $transaccion->id = $transaccion->getIdTable();
            $transaccion->cliente_id = $model->client;
            $transaccion->proforma_id = $model->id;
            $transaccion->fecha_digitada = $this->zonaHoraria();
            /** @noinspection PhpUndefinedFieldInspection */
            $transaccion->usuario_digitado = Yii::$app->user->identity->correo;
            $transaccion->ip = Yii::$app->request->userIP;
            $transaccion->host = strval(php_uname());
            $transaccion->estado = true;
            $transaccion->save();

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
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
     * @return Proforma the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Proforma::findOne($id)) !== null) {
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
}

<?php

namespace app\controllers;

use kartik\widgets\Growl;
use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            $model->id = intval($model->getIdTable());
            $model->contrasena_desc = $model->contrasena;
            $model->contrasena = md5($model->contrasena);
            $model->authKey = md5(rand(1, 9999));
            $model->accessToken = md5(rand(1, 9999));
            $model->fecha_digitada = $this->zonaHoraria();
            $model->usuario_digitado = Yii::$app->user->identity->correo;
            $model->ip = Yii::$app->request->userIP;
            $model->host = strval(php_uname());
            $model->estado = true;
            $model->fecha_inicio = Yii::$app->formatter->asDate(strtotime($model->fecha_inicio), 'Y-MM-dd');
            $model->fecha_cumpleanos = Yii::$app->formatter->asDate(strtotime($model->fecha_cumpleanos), 'Y-MM-dd');
            $model->save();
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success',
                'duration' => 6000,
                'icon' => 'fa fa-users',
                'message' => 'Se ha registrado satisfactoriamente.',
                'title' => 'Usuario Nuevo',
                'positonY' => 'top',
                'positonX' => 'right',
            ]);

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->contrasena_desc = $model->contrasena;
            $model->contrasena = md5($model->contrasena);
            $model->fecha_modificada = $this->zonaHoraria();
            $model->usuario_modificado = Yii::$app->user->identity->correo;
            $model->ip = Yii::$app->request->userIP;
            $model->host = strval(php_uname());
            $model->fecha_inicio = Yii::$app->formatter->asDate(strtotime($model->fecha_inicio), 'Y-MM-dd');
            $model->fecha_cumpleanos = Yii::$app->formatter->asDate(strtotime($model->fecha_cumpleanos), 'Y-MM-dd');
            $model->save();
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success',
                'duration' => 6000,
                'icon' => 'fa fa-users',
                'message' => 'Se ha actualizado satisfactoriamente.',
                'title' => 'Usuario Actualizado',
                'positonY' => 'top',
                'positonX' => 'right',
            ]);

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
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
}

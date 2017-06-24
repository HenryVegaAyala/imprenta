<?php

namespace app\controllers;

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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            $model->id = (int)$model->getIdTable();
            $model->authKey = md5(rand(1, 9999));
            $model->accessToken = md5(rand(1, 9999));
            $model->fecha_digitada = $this->zonaHoraria();
            /** @noinspection PhpUndefinedFieldInspection */
            $model->usuario_digitado = Yii::$app->user->identity->correo;
            $model->ip = Yii::$app->request->userIP;
            $model->host = strval(php_uname());
            $model->estado = (int)$model->estado;
            $model->fecha_inicio = Yii::$app->formatter->asDate(strtotime($model->fecha_inicio), 'Y-MM-dd');
            $model->fecha_cumpleanos = Yii::$app->formatter->asDate(strtotime($model->fecha_cumpleanos), 'Y-MM-dd');
            $model->save();
            $this->encryptPassword($model->id, $model->contrasena);
            $this->notification(1);

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
            $id = $model->id;
            $password = $model->contrasena;
            $model->fecha_modificada = $this->zonaHoraria();
            /** @noinspection PhpUndefinedFieldInspection */
            $model->usuario_modificado = Yii::$app->user->identity->correo;
            $model->ip = Yii::$app->request->userIP;
            $model->host = strval(php_uname());
            $model->estado = (int)$model->estado;
            $model->fecha_inicio = Yii::$app->formatter->asDate(strtotime($model->fecha_inicio), 'Y-MM-dd');
            $model->fecha_cumpleanos = Yii::$app->formatter->asDate(strtotime($model->fecha_cumpleanos), 'Y-MM-dd');
            $model->save();
            $this->encryptPassword($id, $password);
            $this->notification(2);

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
        $this->notification(3);
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
    }/** @noinspection PhpInconsistentReturnPointsInspection */

    /**
     * @param $estado
     */
    public function notification($estado)
    {

        if ($estado == 1) {
            $type = 'success';
            $message = 'Se ha registrado satisfactoriamente.';
            $title = 'Usuario Nuevo';
        } elseif ($estado == 2) {
            $type = 'success';
            $message = 'Se ha actualizado satisfactoriamente.';
            $title = 'Usuario Actualizado';
        } elseif ($estado == 3) {
            $type = 'success';
            $message = 'Se ha eliminado satisfactoriamente.';
            $title = 'Usuario Eliminado';
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

    /**
     * @param $title
     * @param $message
     */
    public function notificationError($title, $message)
    {
        $notification = Yii::$app->getSession()->setFlash('success', [
            'type' => 'danger',
            'duration' => 6000,
            'icon' => 'fa fa-ban',
            'message' => $message,
            'title' => $title,
            'positonY' => 'top',
            'positonX' => 'right',
        ]);

        return $notification;
    }

    /**
     * @param $id
     * @param $password
     * @return string
     */
    public function encryptPassword($id, $password)
    {
        $transaction = Yii::$app->db;
        $transaction->createCommand()
            ->update('usuario',
                [
                    'contrasena' => (string)Yii::$app->getSecurity()->generatePasswordHash($password),
                ],
                'id = ' . (int)$id)
            ->execute();

        return 'ok';
    }
}

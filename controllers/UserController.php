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
        $dataProvider = $searchModel->search(Yii::$app->request->post());

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
            $model->usuario_digitado = Yii::$app->user->identity->correo;
            $model->ip = Yii::$app->request->userIP;
            $model->host = strval(php_uname());
            $model->estado = (int)$model->estado;
            $fecha_inicio = ($model->fecha_inicio == '') ? '' :
                Yii::$app->formatter->asDate(strtotime($model->fecha_inicio), 'Y-MM-dd');
            $model->fecha_inicio = $fecha_inicio;
            $fecha_cumpleanos = ($model->fecha_inicio == '') ? '' :
                Yii::$app->formatter->asDate(strtotime($model->fecha_cumpleanos), 'Y-MM-dd');
            $model->fecha_cumpleanos = $fecha_cumpleanos;
            $model->save();
            $this->encryptPassword($model->id, $model->contrasena);
            $names = $model->nombre . ' ' . $model->apellido;
            $rol = $model->getRol($model->privilegio);
            $this->notification(1, $names, $rol);

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
            $model->fecha_modificada = $this->zonaHoraria();
            $model->usuario_modificado = Yii::$app->user->identity->correo;
            $model->ip = Yii::$app->request->userIP;
            $model->host = strval(php_uname());
            $model->estado = (int)$model->estado;
            $fecha_inicio = ($model->fecha_inicio == '') ? '' :
                Yii::$app->formatter->asDate(strtotime($model->fecha_inicio), 'Y-MM-dd');
            $model->fecha_inicio = $fecha_inicio;
            $fecha_cumpleanos = ($model->fecha_inicio == '') ? '' :
                Yii::$app->formatter->asDate(strtotime($model->fecha_cumpleanos), 'Y-MM-dd');
            $model->fecha_cumpleanos = $fecha_cumpleanos;
            $model->update();
            $names = $model->nombre . ' ' . $model->apellido;
            $rol = $model->getRol($model->privilegio);
            $this->notification(2, $names, $rol);

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionChange($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $id = $model->id;
            $password = $model->contrasena;
            $model->fecha_modificada = $this->zonaHoraria();
            $model->usuario_modificado = Yii::$app->user->identity->correo;
            $model->ip = Yii::$app->request->userIP;
            $model->host = strval(php_uname());
            $model->update();
            $this->encryptPassword($id, $password);
            $names = $model->nombre . ' ' . $model->apellido;
            $rol = $model->getRol($model->privilegio);
            $this->notification(4, $names, $rol);

            return $this->redirect(['index']);
        } else {
            return $this->render('change', [
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
        $user = User::find()->where(['id' => $id])->one();
        $names = $user->nombre . ' ' . $user->apellido;
        $this->notification(3, $names, $rol = '');
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

        return date('Y-m-d h:i:s', time());
    }

    /**
     * @param $estado
     * @param $usuario
     * @param $rol
     */
    public function notification($estado, $usuario, $rol)
    {
        switch ($estado) {
            case 1:
                $title = 'Se registró un Usuario Nuevo';
                $message = 'Se ha registrado satisfactoriamente a ' . $usuario . ' como usuario ' . $rol . '.';
                $type = 'success';
                break;
            case 2:
                $title = 'El Usuario fué Actualizado';
                $message = 'Se ha actualizado satisfactoriamente el usuario ' . $usuario . '.';
                $type = 'success';
                break;
            case 3:
                $title = 'Se Eliminado un Usuario';
                $message = 'Se ha eliminado satisfactoriamente al usuario ' . $usuario . '.';
                $type = 'success';
                break;
            case 4:
                $title = 'Se Actualizado el Perfil de ' . $usuario;
                $message = 'Se ha actualizado satisfactoriamente los datos del perfil.';
                $type = 'success';
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

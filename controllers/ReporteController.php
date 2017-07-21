<?php

namespace app\controllers;

use app\models\Reporte;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

class ReporteController extends Controller
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

    public function actionDashboard()
    {
        return $this->render('dashboard');
    }

    public function actionReporte()
    {
        $model = new Reporte();
        if ($model->load(Yii::$app->request->post())) {

            return $this->redirect('reporte_pdf');
        } else {
            return $this->render('reporte', [
                'model' => $model,
            ]);
        }
    }
}
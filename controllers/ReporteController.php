<?php

namespace app\controllers;

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
        return $this->render('reporte');
    }
}
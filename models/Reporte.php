<?php

namespace app\models;

use yii\base\Model;

class Reporte extends Model
{
    public $fecha_inicio;
    public $fecha_fin;

    public function rules()
    {
        return [
            [['fecha_inicio', 'fecha_fin'], 'required'],
        ];
    }
}
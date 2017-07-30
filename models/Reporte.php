<?php

namespace app\models;

use yii\base\Model;

/**
 * Class Reporte
 * @package app\models
 */
class Reporte extends Model
{
    public $fecha_inicio;
    public $fecha_fin;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['fecha_inicio', 'fecha_fin'], 'required'],
        ];
    }
}

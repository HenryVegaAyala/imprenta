<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "configuracion".
 *
 * @property integer $id
 * @property string $valor_inicial
 * @property string $valor_actual
 * @property string $valor_final
 * @property string $descripcion
 * @property string $fecha_digitada
 * @property string $fecha_modificada
 * @property string $fecha_eliminada
 * @property string $usuario_digitado
 * @property string $usuario_modificado
 * @property string $usuario_eliminado
 * @property string $ip
 * @property string $host
 * @property integer $estado
 */
class Configuracion extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'configuracion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_digitada', 'fecha_modificada', 'fecha_eliminada'], 'safe'],
            [['estado'], 'integer'],
            [['valor_inicial', 'valor_actual', 'valor_final', 'ip'], 'string', 'max' => 30],
            [['descripcion'], 'string', 'max' => 250],
            [['usuario_digitado', 'usuario_modificado', 'usuario_eliminado'], 'string', 'max' => 50],
            [['host'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'valor_inicial' => 'Valor Inicial',
            'valor_actual' => 'Valor Actual',
            'valor_final' => 'Valor Final',
            'descripcion' => 'Descripcion',
            'fecha_digitada' => 'Fecha Digitada',
            'fecha_modificada' => 'Fecha Modificada',
            'fecha_eliminada' => 'Fecha Eliminada',
            'usuario_digitado' => 'Usuario Digitado',
            'usuario_modificado' => 'Usuario Modificado',
            'usuario_eliminado' => 'Usuario Eliminado',
            'ip' => 'Ip',
            'host' => 'Host',
            'estado' => 'Estado',
        ];
    }
}

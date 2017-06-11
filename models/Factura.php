<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "factura".
 *
 * @property integer $id
 * @property string $num_factura
 * @property string $fecha_pago
 * @property string $monto_subtotal
 * @property string $monto_igv
 * @property string $monto_total
 * @property string $fecha_digitada
 * @property string $fecha_modificada
 * @property string $fecha_eliminada
 * @property string $usuario_digitado
 * @property string $usuario_modificado
 * @property string $usuario_eliminado
 * @property string $ip
 * @property string $host
 * @property integer $estado
 *
 * @property FacturaDetalle[] $facturaDetalles
 * @property Transaccion[] $transaccions
 */
class Factura extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'factura';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_pago', 'fecha_digitada', 'fecha_modificada', 'fecha_eliminada'], 'safe'],
            [['monto_subtotal', 'monto_igv', 'monto_total'], 'number'],
            [['estado'], 'integer'],
            [['num_factura'], 'string', 'max' => 12],
            [['usuario_digitado', 'usuario_modificado', 'usuario_eliminado'], 'string', 'max' => 50],
            [['ip'], 'string', 'max' => 30],
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
            'num_factura' => 'Num Factura',
            'fecha_pago' => 'Fecha Pago',
            'monto_subtotal' => 'Monto Subtotal',
            'monto_igv' => 'Monto Igv',
            'monto_total' => 'Monto Total',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturaDetalles()
    {
        return $this->hasMany(FacturaDetalle::className(), ['factura_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaccions()
    {
        return $this->hasMany(Transaccion::className(), ['factura_id' => 'id']);
    }
}

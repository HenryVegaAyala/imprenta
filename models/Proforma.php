<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "proforma".
 *
 * @property integer $id
 * @property string $num_proforma
 * @property string $fecha_ingreso
 * @property string $fecha_envio
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
 * @property ProformaDetalle[] $proformaDetalles
 * @property array $listCliente
 * @property Transaccion[] $transaccions
 */
class Proforma extends ActiveRecord
{

    public $client;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proforma';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_ingreso', 'fecha_envio', 'fecha_digitada', 'fecha_modificada', 'fecha_eliminada'], 'safe'],
            [['monto_subtotal', 'monto_igv', 'monto_total'], 'number'],
            [['estado'], 'integer'],
            [['num_proforma'], 'string', 'max' => 12],
            [['usuario_digitado', 'usuario_modificado', 'usuario_eliminado'], 'string', 'max' => 50],
            [['ip'], 'string', 'max' => 30],
            [['host'], 'string', 'max' => 40],
            [['client'], 'string', 'max' => 1],

            [['fecha_ingreso', 'fecha_envio', 'num_proforma', 'client'], 'required'],

            ['num_proforma', 'match', 'pattern' => "/^.{1,12}$/", 'message' => 'Mínimo un dígito en la proforma.'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'num_proforma' => 'Número de Proforma',
            'fecha_ingreso' => 'Fecha de Ingreso',
            'fecha_envio' => 'Fecha de Envio',
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
            'client' => 'Cliente',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProformaDetalles()
    {
        return $this->hasMany(ProformaDetalle::className(), ['proforma_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaccions()
    {
        return $this->hasMany(Transaccion::className(), ['proforma_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getListCliente()
    {
        $list = ArrayHelper::map(
            Cliente::find()
                ->select(['id' => 'id', 'desc_cliente' => "desc_cliente"])
                ->where('estado = 1')
                ->asArray()
                ->all(), 'id', 'desc_cliente');

        return $list;
    }
}

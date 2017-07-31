<?php

namespace app\models;

use nepstor\validators\DateTimeCompareValidator;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "proforma".
 *
 * @property integer $id
 * @property integer $cliente_id
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
 * @property Factura[] $facturas
 * @property Cliente $cliente
 * @property array $listCliente
 * @property null|string|false $idTable
 * @property ProformaDetalle[] $proformaDetalles
 */
class Proforma extends ActiveRecord
{
    public $cliente_name;
    public $proforma_estado;

    public $nameCompany;
    public $ruc;
    public $businessName;
    public $fiscalAddress;

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
            [['cliente_id', 'estado'], 'integer'],
            [['fecha_ingreso', 'fecha_envio', 'fecha_digitada', 'fecha_modificada', 'fecha_eliminada'], 'safe'],
            [['monto_subtotal', 'monto_igv', 'monto_total'], 'number'],
            [['num_proforma'], 'string', 'max' => 12],
            [['usuario_digitado', 'usuario_modificado', 'usuario_eliminado'], 'string', 'max' => 50],
            [['ip'], 'string', 'max' => 30],
            [['host'], 'string', 'max' => 150],
            [
                ['cliente_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Cliente::className(),
                'targetAttribute' => ['cliente_id' => 'id'],
            ],
            [
                [
                    'fecha_ingreso',
                    'fecha_envio',
                    'cliente_id',
                ],
                'required',
            ],
            ['num_proforma', 'match', 'pattern' => "/^.{1,12}$/", 'message' => 'Mínimo un dígito en la proforma.'],

            ['num_proforma', 'required', 'message' => 'N° de Proforma no puede estar vacía.'],

            ['monto_subtotal', 'required', 'message' => 'Subtotal esta vacío.'],
            ['monto_igv', 'required', 'message' => 'I.G.V esta vacío.'],
            ['monto_total', 'required', 'message' => 'Total esta vacío.'],

            ['fecha_envio', 'date', 'format' => 'php:d-m-Y', 'skipOnEmpty' => false],
            ['fecha_ingreso', 'date', 'format' => 'php:d-m-Y', 'skipOnEmpty' => false],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cliente_id' => 'Cliente',
            'num_proforma' => 'Número de Proforma',
            'fecha_ingreso' => 'Fecha de Ingreso',
            'fecha_envio' => 'Fecha de Envio',
            'monto_subtotal' => 'Subtotal',
            'monto_igv' => 'I.G.V',
            'monto_total' => 'Total',
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
    public function getFacturas()
    {
        return $this->hasMany(Factura::className(), ['proforma_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::className(), ['id' => 'cliente_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProformaDetalles()
    {
        return $this->hasMany(ProformaDetalle::className(), ['proforma_id' => 'id']);
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

    /**
     * @return false|null|string
     */
    public function getIdTable()
    {
        $query = new Query();
        $sentence = new Expression('IFNULL(MAX(id), 0) + 1');
        $query->select($sentence)->from('proforma');
        $command = $query->createCommand();
        $value = $command->queryScalar();

        return $value;
    }

    /**
     * @return array
     */
    public static function status()
    {
        $status = [
            0 => 'Anulado',
            1 => 'Creado',
            2 => 'En Proceso',
            3 => 'Despachadado / Atendido',
        ];

        return $status;
    }

    /**
     * @param $id
     * @return bool
     */
    public function validateProforma($id)
    {
        $query = new Query();
        $query->select('id')->from('proforma')->where('num_proforma = :id', [':id' => $id]);
        $command = $query->createCommand();
        $data = $command->queryScalar();

        return (!empty($data)) ? true : false;
    }

    /**
     * @return array
     */
    public function listCliente()
    {
        return ArrayHelper::map(
            Cliente::find()
                ->select(['id', 'desc_cliente'])
                ->where('estado = 1')
                ->limit(5)
                ->orderBy('desc_cliente')
                ->asArray()
                ->all(), 'id', 'desc_cliente');
    }
}

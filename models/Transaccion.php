<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "transaccion".
 *
 * @property integer $id
 * @property integer $cliente_id
 * @property integer $proforma_id
 * @property integer $guia_id
 * @property integer $factura_id
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
 * @property Cliente $cliente
 * @property Factura $factura
 * @property Guia $guia
 * @property null|string|false $idTable
 * @property Proforma $proforma
 */
class Transaccion extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaccion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cliente_id'], 'required'],
            [['cliente_id', 'proforma_id', 'guia_id', 'factura_id', 'estado'], 'integer'],
            [['fecha_digitada', 'fecha_modificada', 'fecha_eliminada'], 'safe'],
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
                ['factura_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Factura::className(),
                'targetAttribute' => ['factura_id' => 'id'],
            ],
            [
                ['guia_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Guia::className(),
                'targetAttribute' => ['guia_id' => 'id'],
            ],
            [
                ['proforma_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Proforma::className(),
                'targetAttribute' => ['proforma_id' => 'id'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cliente_id' => 'Cliente ID',
            'proforma_id' => 'Proforma ID',
            'guia_id' => 'Guia ID',
            'factura_id' => 'Factura ID',
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
    public function getCliente()
    {
        return $this->hasOne(Cliente::className(), ['id' => 'cliente_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactura()
    {
        return $this->hasOne(Factura::className(), ['id' => 'factura_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuia()
    {
        return $this->hasOne(Guia::className(), ['id' => 'guia_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProforma()
    {
        return $this->hasOne(Proforma::className(), ['id' => 'proforma_id']);
    }

    /**
     * @return false|null|string
     */
    public function getIdTable()
    {
        $query = new Query();
        $sentence = new Expression('IFNULL(MAX(id), 0) + 1');
        $query->select($sentence)->from('transaccion');
        $command = $query->createCommand();
        $value = $command->queryScalar();

        return $value;
    }
}

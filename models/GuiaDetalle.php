<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "guia_detalle".
 *
 * @property integer $id
 * @property integer $guia_id
 * @property integer $cantidad
 * @property string $descripcion
 * @property string $precio
 * @property string $monto_subtotal
 * @property string $monto_igv
 * @property string $monto_total
 * @property string $fecha_digitada
 * @property string $fecha_modificada
 * @property string $fecha_eliminada
 * @property string $usuario_digitado
 * @property string $usuario_modificado
 * @property string $usuario_eliminado
 *
 * @property Guia $guia
 */
class GuiaDetalle extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guia_detalle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guia_id'], 'required'],
            [['guia_id', 'cantidad'], 'integer'],
            [['precio', 'monto_subtotal', 'monto_igv', 'monto_total'], 'number'],
            [['fecha_digitada', 'fecha_modificada', 'fecha_eliminada'], 'safe'],
            [['descripcion'], 'string', 'max' => 250],
            [['usuario_digitado', 'usuario_modificado', 'usuario_eliminado'], 'string', 'max' => 50],
            [
                ['guia_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Guia::className(),
                'targetAttribute' => ['guia_id' => 'id'],
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
            'guia_id' => 'Guia ID',
            'cantidad' => 'Cantidad',
            'descripcion' => 'Descripcion',
            'precio' => 'Precio',
            'monto_subtotal' => 'Monto Subtotal',
            'monto_igv' => 'Monto Igv',
            'monto_total' => 'Monto Total',
            'fecha_digitada' => 'Fecha Digitada',
            'fecha_modificada' => 'Fecha Modificada',
            'fecha_eliminada' => 'Fecha Eliminada',
            'usuario_digitado' => 'Usuario Digitado',
            'usuario_modificado' => 'Usuario Modificado',
            'usuario_eliminado' => 'Usuario Eliminado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuia()
    {
        return $this->hasOne(Guia::className(), ['id' => 'guia_id']);
    }
}

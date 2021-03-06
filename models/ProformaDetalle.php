<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "proforma_detalle".
 *
 * @property integer $id
 * @property integer $proforma_id
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
 * @property Proforma $proforma
 */
class ProformaDetalle extends ActiveRecord
{
    public $total;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proforma_detalle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cantidad'], 'integer'],
            [['precio', 'monto_subtotal', 'monto_igv', 'monto_total', 'total'], 'number'],
            [['fecha_digitada', 'fecha_modificada', 'fecha_eliminada'], 'safe'],
            [['descripcion'], 'string', 'max' => 250],
            [['usuario_digitado', 'usuario_modificado', 'usuario_eliminado'], 'string', 'max' => 50],

            [['cantidad'], 'required', 'message' => 'Cantidad es requerido.'],
            [['precio'], 'required', 'message' => 'Precio es requerido.'],
            [['descripcion'], 'required', 'message' => 'Descripción es requerido.'],
            [['total'], 'required', 'message' => 'Total es requerido.'],

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
            'proforma_id' => 'Proforma ID',
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
            'total' => 'Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProforma()
    {
        return $this->hasOne(Proforma::className(), ['id' => 'proforma_id']);
    }

    /**
     * @param $id
     * @return false|null|string
     */
    public function detailsProforma($id)
    {
        $query = new Query();
        $query->select('*')->from('proforma_detalle')->where("proforma_id ='" . $id . "'");
        $command = $query->createCommand();
        $data = $command->queryAll();

        return $data;
    }

    /**
     * @param $id
     * @return false|null|string
     */
    public function proforma($id)
    {
        $query = new Query();
        $query->select('*')->from('proforma')->where("id ='" . $id . "'");
        $command = $query->createCommand();
        $data = $command->queryAll();

        return $data;
    }
}

<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "cliente".
 *
 * @property integer $id
 * @property string $desc_cliente
 * @property string $dir_fisica
 * @property string $numero_ruc
 * @property string $num_telf1
 * @property string $num_telf2
 * @property string $dir_mail1
 * @property string $dir_mail2
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
 * @property Transaccion[] $transaccions
 */
class Cliente extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cliente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_digitada', 'fecha_modificada', 'fecha_eliminada'], 'safe'],
            [['estado'], 'integer'],
            [['desc_cliente', 'dir_fisica'], 'string', 'max' => 100],
            [['numero_ruc', 'num_telf1', 'num_telf2'], 'string', 'max' => 20],
            [['dir_mail1', 'dir_mail2', 'host'], 'string', 'max' => 40],
            [['usuario_digitado', 'usuario_modificado', 'usuario_eliminado'], 'string', 'max' => 50],
            [['ip'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'desc_cliente' => 'Desc Cliente',
            'dir_fisica' => 'Dir Fisica',
            'numero_ruc' => 'Numero Ruc',
            'num_telf1' => 'Num Telf1',
            'num_telf2' => 'Num Telf2',
            'dir_mail1' => 'Dir Mail1',
            'dir_mail2' => 'Dir Mail2',
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
    public function getTransaccions()
    {
        return $this->hasMany(Transaccion::className(), ['cliente_id' => 'id']);
    }
}

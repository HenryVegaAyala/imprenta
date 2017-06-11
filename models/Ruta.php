<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "ruta".
 *
 * @property integer $id
 * @property integer $usuario_id
 * @property string $rol_usuario
 * @property string $fecha_logeado
 * @property string $usuario_logeado
 * @property string $ip
 * @property string $host
 * @property integer $estado
 *
 * @property User $usuario
 */
class Ruta extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ruta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id'], 'required'],
            [['usuario_id', 'estado'], 'integer'],
            [['fecha_logeado'], 'safe'],
            [['rol_usuario', 'ip'], 'string', 'max' => 30],
            [['usuario_logeado'], 'string', 'max' => 50],
            [['host'], 'string', 'max' => 40],
            [
                ['usuario_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['usuario_id' => 'id'],
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
            'usuario_id' => 'Usuario ID',
            'rol_usuario' => 'Rol Usuario',
            'fecha_logeado' => 'Fecha Logeado',
            'usuario_logeado' => 'Usuario Logeado',
            'ip' => 'Ip',
            'host' => 'Host',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_id']);
    }
}

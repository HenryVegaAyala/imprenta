<?php

namespace app\models;

/**
 * This is the model class for table "auditoria".
 *
 * @property integer $id
 * @property string $rol_usuario
 * @property string $ultima_sesion
 * @property string $usuario_logeado
 * @property string $ip
 * @property string $host
 * @property integer $estado
 */
class Auditoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auditoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ultima_sesion'], 'safe'],
            [['estado'], 'integer'],
            [['rol_usuario', 'ip'], 'string', 'max' => 30],
            [['usuario_logeado'], 'string', 'max' => 50],
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
            'rol_usuario' => 'Rol Usuario',
            'ultima_sesion' => 'Ultima Sesion',
            'usuario_logeado' => 'Usuario Logeado',
            'ip' => 'Ip',
            'host' => 'Host',
            'estado' => 'Estado',
        ];
    }
}

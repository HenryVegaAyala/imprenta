<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "notificaciones".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $creado
 * @property string $usuario
 * @property integer $estado
 */
class Notificaciones extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notificaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo', 'descripcion', 'creado', 'usuario'], 'required'],
            [['creado'], 'safe'],
            [['estado'], 'integer'],
            [['titulo', 'descripcion', 'usuario'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'creado' => 'Creado',
            'usuario' => 'Usuario',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return array
     */
    public function notificaciones()
    {
        $query = new Query();
        $query->select([
            'titulo',
            'descripcion',
            'creado',
            'usuario',
        ])->from('notificaciones')->where('estado = 1')->limit(5);
        $command = $query->createCommand();
        $data = $command->queryAll();

        return $data;
    }
}

<?php

use yii\db\Schema;

class m170607_070101_usuario extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('usuario', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(50),
            'apellido' => $this->string(50),
            'telefono' => $this->string(15),
            'dni' => $this->string(8),
            'correo' => $this->string(30),
            'privilegio' => $this->char(1),
            'contrasena' => $this->string(150),
            'contrasena_desc' => $this->string(45),
            'authKey' => $this->string(50),
            'accessToken' => $this->string(50),
            'fecha_digitada' => $this->datetime(),
            'fecha_modificada' => $this->datetime(),
            'fecha_eliminada' => $this->datetime(),
            'usuario_digitado' => $this->string(50),
            'usuario_modificado' => $this->string(50),
            'usuario_eliminado' => $this->string(50),
            'ip' => $this->string(30),
            'host' => $this->string(150),
            'estado' => $this->smallInteger(1),
            'genero' => $this->char(1),
            'fecha_inicio' => $this->date(),
            'fecha_cumpleanos' => $this->date(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('usuario');
    }
}

<?php

use yii\db\Migration;
use yii\db\Schema;

class m170626_050101_usuario extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('usuario', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(80),
            'apellido' => $this->string(80),
            'telefono' => $this->string(15),
            'dni' => $this->string(8),
            'correo' => $this->string(40),
            'privilegio' => $this->char(1),
            'contrasena' => $this->string(150),
            'authKey' => $this->string(150),
            'accessToken' => $this->string(150),
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

        $this->insert('usuario', [
            'correo' => 'admin@branusac.pe',
            'contrasena' => '$2y$13$kH5bMOB6mnXieI8PD9FQTeKHym2UFtntFRr72Hm9KAWxv9NGnCja2',
            'privilegio' => 'G',
            'estado' => '1',
        ]);
    }

    public function down()
    {
        $this->delete('usuario', ['id' => 1]);
        $this->dropTable('usuario');
    }
}

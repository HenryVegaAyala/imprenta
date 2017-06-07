<?php

use yii\db\Schema;

class m170607_070101_configuracion extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('configuracion', [
            'id' => $this->primaryKey(),
            'valor_inicial' => $this->string(30),
            'valor_actual' => $this->string(30),
            'valor_final' => $this->string(30),
            'descripcion' => $this->string(250),
            'fecha_digitada' => $this->datetime(),
            'fecha_modificada' => $this->datetime(),
            'fecha_eliminada' => $this->datetime(),
            'usuario_digitado' => $this->string(50),
            'usuario_modificado' => $this->string(50),
            'usuario_eliminado' => $this->string(50),
            'ip' => $this->string(30),
            'host' => $this->string(40),
            'estado' => $this->smallInteger(1),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('configuracion');
    }
}

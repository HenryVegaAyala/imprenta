<?php

use yii\db\Schema;

class m170607_070101_ruta extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('ruta', [
            'id' => $this->primaryKey(),
            'usuario_id' => $this->integer(11)->notNull(),
            'rol_usuario' => $this->string(30),
            'fecha_logeado' => $this->datetime(),
            'usuario_logeado' => $this->string(50),
            'ip' => $this->string(30),
            'host' => $this->string(40),
            'estado' => $this->smallInteger(1),
            'FOREIGN KEY ([[usuario_id]]) REFERENCES usuario ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('ruta');
    }
}

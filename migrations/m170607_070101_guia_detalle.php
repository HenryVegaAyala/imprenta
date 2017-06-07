<?php

use yii\db\Schema;

class m170607_070101_guia_detalle extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('guia_detalle', [
            'id' => $this->primaryKey(),
            'guia_id' => $this->integer(11)->notNull(),
            'cantidad' => $this->integer(11),
            'descripcion' => $this->string(250),
            'precio' => $this->decimal(10, 2),
            'monto_subtotal' => $this->decimal(10, 2),
            'monto_igv' => $this->decimal(10, 2),
            'monto_total' => $this->decimal(10, 2),
            'fecha_digitada' => $this->datetime(),
            'fecha_modificada' => $this->datetime(),
            'fecha_eliminada' => $this->datetime(),
            'usuario_digitado' => $this->string(50),
            'usuario_modificado' => $this->string(50),
            'usuario_eliminado' => $this->string(50),
            'FOREIGN KEY ([[guia_id]]) REFERENCES guia ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('guia_detalle');
    }
}

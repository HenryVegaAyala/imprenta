<?php

use yii\db\Schema;

class m170626_050101_transaccion extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('transaccion', [
            'id' => $this->primaryKey(),
            'cliente_id' => $this->integer(11)->notNull(),
            'proforma_id' => $this->integer(11),
            'guia_id' => $this->integer(11),
            'factura_id' => $this->integer(11),
            'fecha_digitada' => $this->datetime(),
            'fecha_modificada' => $this->datetime(),
            'fecha_eliminada' => $this->datetime(),
            'usuario_digitado' => $this->string(50),
            'usuario_modificado' => $this->string(50),
            'usuario_eliminado' => $this->string(50),
            'ip' => $this->string(30),
            'host' => $this->string(150),
            'estado' => $this->smallInteger(1),
            'FOREIGN KEY ([[cliente_id]]) REFERENCES cliente ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[factura_id]]) REFERENCES factura ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[guia_id]]) REFERENCES guia ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[proforma_id]]) REFERENCES proforma ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
                
    }

    public function down()
    {
        $this->dropTable('transaccion');
    }
}

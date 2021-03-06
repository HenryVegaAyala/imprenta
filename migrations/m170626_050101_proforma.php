<?php

use yii\db\Schema;

class m170626_050101_proforma extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('proforma', [
            'id' => $this->primaryKey(),
            'num_proforma' => $this->string(12),
            'fecha_ingreso' => $this->date(),
            'fecha_envio' => $this->date(),
            'monto_subtotal' => $this->decimal(10,2),
            'monto_igv' => $this->decimal(10,2),
            'monto_total' => $this->decimal(10,2),
            'fecha_digitada' => $this->datetime(),
            'fecha_modificada' => $this->datetime(),
            'fecha_eliminada' => $this->datetime(),
            'usuario_digitado' => $this->string(50),
            'usuario_modificado' => $this->string(50),
            'usuario_eliminado' => $this->string(50),
            'ip' => $this->string(30),
            'host' => $this->string(150),
            'estado' => $this->smallInteger(1),
            ], $tableOptions);
                
    }

    public function down()
    {
        $this->dropTable('proforma');
    }
}

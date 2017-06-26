<?php

use yii\db\Schema;

class m170626_050101_cliente extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('cliente', [
            'id' => $this->primaryKey(),
            'desc_cliente' => $this->string(100),
            'dir_fisica' => $this->string(100),
            'numero_ruc' => $this->string(20),
            'num_telf1' => $this->string(20),
            'num_telf2' => $this->string(20),
            'dir_mail1' => $this->string(40),
            'dir_mail2' => $this->string(40),
            'fecha_digitada' => $this->datetime(),
            'fecha_modificada' => $this->datetime(),
            'fecha_eliminada' => $this->datetime(),
            'usuario_digitado' => $this->string(50),
            'usuario_modificado' => $this->string(50),
            'usuario_eliminado' => $this->string(50),
            'ip' => $this->string(30),
            'host' => $this->string(40),
            'estado' => $this->smallInteger(1),
            'distrito' => $this->string(40),
            'provincia' => $this->string(40),
            'referencia' => $this->string(40),
            ], $tableOptions);
                
    }

    public function down()
    {
        $this->dropTable('cliente');
    }
}

<?php

use yii\db\Schema;

class m170626_050101_auditoria extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('auditoria', [
            'id' => $this->primaryKey(),
            'rol_usuario' => $this->string(30),
            'ultima_sesion' => $this->datetime(),
            'usuario_logeado' => $this->string(50),
            'ip' => $this->string(30),
            'host' => $this->string(40),
            'estado' => $this->smallInteger(1),
            ], $tableOptions);
                
    }

    public function down()
    {
        $this->dropTable('auditoria');
    }
}

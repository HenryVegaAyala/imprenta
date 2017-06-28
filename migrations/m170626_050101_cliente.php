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
            'razon_social' => $this->string(100),
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
            'departamento' => $this->string(40),
            'referencia' => $this->string(40),
        ], $tableOptions);

        $this->insert('cliente', [
            'desc_cliente' => 'Ripley',
            'dir_fisica' => 'Av. las Begonias Nro. 545',
            'numero_ruc' => '20337564373',
            'num_telf1' => '6115700',
            'num_telf2' => '6115710',
            'dir_mail1' => 'distribuidora@ripleyperu.com',
            'estado' => '1',
            'distrito' => 'San Isidro',
            'provincia' => 'Lima',
            'departamento' => 'Lima, Perú',
            'referencia' => 'Jardin',
            'razon_social' => 'TIENDAS POR DEPARTAMENTO RIPLEY S.A.',
        ]);

        $this->insert('cliente', [
            'desc_cliente' => 'Banco Ripley',
            'dir_fisica' => 'Av. Paseo de la Republica Nro. 3118',
            'numero_ruc' => '20259702411',
            'num_telf1' => '6115700',
            'num_telf2' => '6115720',
            'dir_mail1' => 'comercial@rippleyperu.com',
            'estado' => '1',
            'distrito' => 'San Isidro',
            'provincia' => 'Lima',
            'departamento' => 'Lima, Perú',
            'referencia' => '(Piso 11)',
            'razon_social' => 'BANCO RIPLEY PERU S.A.',
        ]);

        $this->insert('cliente', [
            'desc_cliente' => 'Xerox Peru',
            'dir_fisica' => 'Av. Dionisio Derteano Nro. 144 Dpto. B Int. 1001',
            'numero_ruc' => '20100119065',
            'num_telf1' => '6166663',
            'num_telf2' => '6166666',
            'dir_mail1' => 'comercial@xerox.com',
            'estado' => '1',
            'distrito' => 'San Isidro',
            'provincia' => 'Lima',
            'departamento' => 'Lima, Perú',
            'referencia' => 'Santa Ana',
            'razon_social' => 'XEROX DEL PERU S.A.',
        ]);
    }

    public function down()
    {
        $this->dropTable('cliente');
    }
}

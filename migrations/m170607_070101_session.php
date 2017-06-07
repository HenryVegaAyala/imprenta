<?php

use yii\db\Schema;

class m170607_070101_session extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('session', [
            'id' => $this->char(40)->notNull(),
            'expire' => $this->integer(11),
            'data' => $this->binary(),
            'PRIMARY KEY ([[id]])',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('session');
    }
}

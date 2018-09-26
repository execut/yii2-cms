<?php

use execut\yii\migration\Migration;
use execut\yii\migration\Inverter;

class m180917_112935_base extends Migration
{
    public function initInverter(Inverter $i)
    {
        $i->table('shops_shops')
            ->create($this->defaultColumns([
                'name' => $this->string()->notNull(),
                'visible' => $this->boolean()->notNull(),
            ]));
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}

<?php

use yii\db\Migration;

class m191103_090815_addLeadTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('lead', [
            'id' => $this->bigPrimaryKey(),
            'company' => $this->integer(),
            'name' => $this->string(),
            'contact' => $this->bigInteger(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191103_090815_addLeadTable cannot be reverted.\n";

        return false;
    }
}

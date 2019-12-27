<?php

use yii\db\Migration;

class m191103_094710_addValueTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('value', [
            'id' => $this->bigPrimaryKey(),
            'contact' => $this->bigInteger(),
            'field' => $this->integer(),
            'value' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191103_094710_addValueTable cannot be reverted.\n";

        return false;
    }
}

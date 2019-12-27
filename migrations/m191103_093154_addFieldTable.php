<?php

use yii\db\Migration;

class m191103_093154_addFieldTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('field', [
            'id' => $this->bigPrimaryKey(),
            'company' => $this->integer(),
            'context' => $this->integer(),
            'type' => $this->integer(),
            'label' => $this->string(),
            'requried' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191103_093154_addFieldTable cannot be reverted.\n";

        return false;
    }
}

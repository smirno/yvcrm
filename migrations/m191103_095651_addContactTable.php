<?php

use yii\db\Migration;

/**
 * Class m191103_095651_addContactTable
 */
class m191103_095651_addContactTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('contact', [
            'id' => $this->bigPrimaryKey(),
            'company' => $this->integer(),
            'firstname' => $this->string(),
            'lastname' => $this->string(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191103_095651_addContactTable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191103_095651_addContactTable cannot be reverted.\n";

        return false;
    }
    */
}

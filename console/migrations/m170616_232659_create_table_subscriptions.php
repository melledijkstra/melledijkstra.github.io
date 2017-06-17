<?php

use yii\db\Migration;

class m170616_232659_create_table_subscriptions extends Migration
{
    public function up()
    {
        $this->createTable('subscriptions', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('subscriptions');
    }
}

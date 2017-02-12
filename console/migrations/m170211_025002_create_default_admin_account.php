<?php

use yii\db\Migration;

class m170211_025002_create_default_admin_account extends Migration
{
    public function up()
    {
        $user = new \common\models\User([
            'username'  => 'Admin',
            'email'     => 'admin@gmail.com',
            'password'  => '12345678',
            'role'      => 1,
        ]);
        $user->save();
    }

    public function down()
    {
        echo "m170211_025002_create_default_admin_account cannot be reverted.\n";

        return false;
    }
}

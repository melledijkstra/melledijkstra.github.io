<?php

use yii\db\Migration;

/**
 * Handles adding role to table `user`.
 */
class m161113_184159_add_role_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'role', $this->integer()->after('email')->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'role');
    }
}

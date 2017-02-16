<?php

use yii\db\Migration;

class m170213_184906_add_column_sneak_peek_to_guides_table extends Migration
{
    public function up()
    {
        $this->addColumn('guides', 'sneak_peek', $this->string(700)->after('title'));
    }

    public function down()
    {
        $this->dropColumn('guides', 'sneak_peek');
    }
}

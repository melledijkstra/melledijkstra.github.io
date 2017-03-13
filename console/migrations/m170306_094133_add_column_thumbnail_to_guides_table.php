<?php

use yii\db\Migration;

class m170306_094133_add_column_thumbnail_to_guides_table extends Migration
{
    public function up()
    {
        $this->addColumn('guides', 'thumbnail', $this->string()->after('sneak_peek'));
    }

    public function down()
    {
        $this->dropColumn('guides', 'thumbnail');
    }
}

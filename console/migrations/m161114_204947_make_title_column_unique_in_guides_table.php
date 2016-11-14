<?php

use yii\db\Migration;

class m161114_204947_make_title_column_unique_in_guides_table extends Migration
{
    public function up()
    {
        $this->alterColumn('guides','title',$this->string()->notNull()->unique());
    }

    public function down()
    {
        $this->dropIndex('title','guides');
        $this->alterColumn('guides','title',$this->string()->notNull()->after('id'));
    }
}

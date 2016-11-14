<?php

use yii\db\Migration;

class m161114_221653_alter_column_unique_title_on_projects_table extends Migration
{
    public function up()
    {
        $this->alterColumn('projects','title',$this->string()->notNull()->unique());
    }

    public function down()
    {
        $this->dropIndex('title','projects');
        $this->alterColumn('projects','title',$this->string()->notNull()->after('id'));
    }
}

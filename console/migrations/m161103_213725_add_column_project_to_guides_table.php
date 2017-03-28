<?php

use common\models\Guide;
use yii\db\Migration;

class m161103_213725_add_column_project_to_guides_table extends Migration
{
    public function up()
    {
        $this->addColumn('guides', 'project', $this->integer()->after('filename'));
        // Link guide to project
        $this->addForeignKey('fk_guides_projects', 'guides','project','projects','id','SET NULL','CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_guides_projects','guides');
        $this->dropColumn('guides','project');
    }

}

<?php

use yii\db\Migration;

class m171230_173250_add_credit_to_project_and_guide_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('projects', 'credits', $this->string()->after('thumbnail'));
        $this->addColumn('guides', 'credits', $this->string()->after('thumbnail'));
        $this->addColumn('series', 'credits', $this->string()->after('image'));
    }

    public function safeDown()
    {
        $this->dropColumn('projects', 'credits');
        $this->dropColumn('guides', 'credits');
        $this->dropColumn('series', 'credits');
    }
}

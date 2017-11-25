<?php

use yii\db\Migration;

class m171125_135824_add_size_to_project_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('projects', 'size', $this->integer()->notNull()->after('thumbnail'));
    }

    public function safeDown()
    {
        $this->dropColumn('projects', 'size');
    }
}

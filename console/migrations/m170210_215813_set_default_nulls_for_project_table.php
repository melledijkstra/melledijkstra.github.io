<?php

use yii\db\Migration;

class m170210_215813_set_default_nulls_for_project_table extends Migration
{
    public function up()
    {
        $this->alterColumn('projects', 'description', $this->string()->defaultValue(null));
        $this->alterColumn('projects', 'thumbnail', $this->string()->defaultValue(null));
        $this->alterColumn('projects', 'external_url', $this->string()->defaultValue(null));
    }

    public function down()
    {
        $this->alterColumn('projects', 'external_url', $this->string());
        $this->alterColumn('projects', 'thumbnail', $this->string());
        $this->alterColumn('projects', 'description', $this->string());
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `projects`.
 */
class m161103_105504_create_projects_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('projects', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->string(),
            'thumbnail' => $this->string(),
            'external_url' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('fk_projects_user1','projects','created_by','user','id','SET NULL','CASCADE');
        $this->addForeignKey('fk_projects_user2','projects','updated_by','user','id','SET NULL','CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_projects_user1','projects');
        $this->dropForeignKey('fk_projects_user2','projects');

        $this->dropTable('projects');
    }
}

<?php

use yii\db\Migration;

class m170211_224352_refactoring_of_tables extends Migration
{
    public function up()
    {
        // correct foreign keys
        $this->addForeignKey('categories_fk1','categories','created_by','user','id','SET NULL','CASCADE');
        $this->addForeignKey('categories_fk2','categories','updated_by','user','id','SET NULL','CASCADE');

        // drop foreign key before renaming column
        // @see: http://stackoverflow.com/questions/2014498/renaming-foreign-key-columns-in-mysql
        $this->dropForeignKey('fk_guides_projects', 'guides');
        // rename to project_id so no confusion exist in code
        $this->renameColumn('guides','project','project_id');
        $this->addForeignKey('fk_guides_projects', 'guides','project_id','projects','id','SET NULL','CASCADE');

        $this->addColumn('guides', 'difficulty', $this->integer()->unsigned()->after('project_id'));
        $this->addColumn('guides', 'duration', $this->integer()->unsigned()->comment("The time it takes to finish or read guide in minutes")->after('difficulty'));
    }

    public function down()
    {
        $this->dropColumn('guides', 'duration');
        $this->dropColumn('guides', 'difficulty');

        $this->renameColumn('guides','project_id','project');

        $this->dropForeignKey('categories_fk2','categories');
        $this->dropForeignKey('categories_fk1','categories');
    }

}

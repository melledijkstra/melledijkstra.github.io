<?php

use yii\db\Migration;

/**
 * Handles the creation of table `languages`.
 */
class m170212_114839_create_languages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('languages', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'color' => $this->string(),

            // Standard stuff
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('fk_languages_user1','languages','created_by','user','id','SET NULL','CASCADE');
        $this->addForeignKey('fk_languages_user2','languages','updated_by','user','id','SET NULL','CASCADE');

        $this->addColumn('guides', 'language_id', $this->integer()->after('duration'));

        $this->addForeignKey('fk_guides_languages', 'guides', 'language_id', 'languages', 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_guides_languages', 'guides');

        $this->dropColumn('guides', 'language_id');

        $this->dropTable('languages');
    }
}

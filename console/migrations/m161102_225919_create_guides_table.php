<?php

use yii\db\Migration;

/**
 * Handles the creation of table `guides`.
 */
class m161102_225919_create_guides_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('guides', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'filename' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);


        $this->addForeignKey('fk_guides_user1','guides','created_by','user','id','SET NULL','CASCADE');
        $this->addForeignKey('fk_guides_user2','guides','updated_by','user','id','SET NULL','CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_guides_user1','guides');
        $this->dropForeignKey('fk_guides_user2','guides');

        $this->dropTable('guides');
    }
}

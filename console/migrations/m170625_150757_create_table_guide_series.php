<?php

use yii\db\Migration;

class m170625_150757_create_table_guide_series extends Migration
{
    public function up()
    {
        $this->createTable('series', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->unique(),
            'image' => $this->string()->unique(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('fk_series_user1','series','created_by','user','id','SET NULL','CASCADE');
        $this->addForeignKey('fk_series_user2','series','updated_by','user','id','SET NULL','CASCADE');

        // junction table to link guides with series (Many to Many)
        $this->createTable('series_guides', [
            'series_id' => $this->integer()->notNull(),
            'guide_id' => $this->integer()->notNull()->unique(),
            'order' => $this->smallInteger()->unsigned()->notNull(), // UNSIGNED SMALLINT 0 - 65535
            'PRIMARY KEY(`series_id`, `order`)',
        ]);

        // creates index for column `series_id`
        $this->createIndex(
            'idx-series_guides-series_id',
            'series_guides',
            'series_id'
        );

        // add foreign key for table `series`
        $this->addForeignKey(
            'fk-series_guides-series_id',
            'series_guides',
            'series_id',
            'series',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // creates index for column `guide_id`
        $this->createIndex(
            'idx-series_guides-guides_id',
            'series_guides',
            'guide_id'
        );

        // add foreign key for table `guides`
        $this->addForeignKey(
            'fk-series_guides-guides_id',
            'series_guides',
            'guide_id',
            'guides',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('series_guides');
        $this->dropTable('series');
    }
}

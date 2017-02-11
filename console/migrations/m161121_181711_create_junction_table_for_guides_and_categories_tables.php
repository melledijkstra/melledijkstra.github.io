<?php

use yii\db\Migration;

/**
 * Handles the creation of table `guides_categories`.
 * Has foreign keys to the tables:
 *
 * - `guides`
 * - `categories`
 */
class m161121_181711_create_junction_table_for_guides_and_categories_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('guides_categories', [
            'guide_id' => $this->integer(),
            'category_id' => $this->integer(),
            'PRIMARY KEY(guide_id, category_id)',
        ]);

        // creates index for column `guide_id`
        $this->createIndex(
            'idx-guides_categories-guides_id',
            'guides_categories',
            'guide_id'
        );

        // add foreign key for table `guides`
        $this->addForeignKey(
            'fk-guides_categories-guides_id',
            'guides_categories',
            'guide_id',
            'guides',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            'idx-guides_categories-categories_id',
            'guides_categories',
            'category_id'
        );

        // add foreign key for table `categories`
        $this->addForeignKey(
            'fk-guides_categories-categories_id',
            'guides_categories',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `guides`
        $this->dropForeignKey(
            'fk-guides_categories-guides_id',
            'guides_categories'
        );

        // drops index for column `guides_id`
        $this->dropIndex(
            'idx-guides_categories-guides_id',
            'guides_categories'
        );

        // drops foreign key for table `categories`
        $this->dropForeignKey(
            'fk-guides_categories-categories_id',
            'guides_categories'
        );

        // drops index for column `categories_id`
        $this->dropIndex(
            'idx-guides_categories-categories_id',
            'guides_categories'
        );

        $this->dropTable('guides_categories');
    }
}

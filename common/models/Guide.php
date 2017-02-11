<?php

namespace common\models;

use common\components\db\MActiveRecord;
use kartik\markdown\Markdown;
use Yii;

/**
 * This is the model class for table "guides".
 *
 * @property integer $id
 * @property string $title
 * @property string $filename
 * @property string $filepath
 * @property integer $project
 *
 * @property Project $project0
 * @property Category[] $categories
 */
class Guide extends MActiveRecord
{

    /** @var $guide_text string This is the markdown entered by a user which needs to be saved to a file */
    public $guide_text;

    /** @var array The linked categories */
    public $category_ids = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guides';
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert) && $this->saveGuideFile($this->guide_text)) {
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        GuidesCategory::deleteAll(['guide_id' => $this->id]);
        if(is_array($this->category_ids)) {
            foreach($this->category_ids as $category_id) {
                $this->link('categories', Category::findOne($category_id));
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete()) {
            // Try and unlink the file
            if (file_exists($this->filepath)) {
                unlink($this->filepath);
            }
            // Delete the file before deleting guide from database
            $this->deleteGuideFile();
            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        if(file_exists($this->filepath)) {
            $this->guide_text = file_get_contents($this->filepath);
        }
        foreach($this->categories as $category) {
            $this->category_ids[] = $category->id;
        }
        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'guide_text'], 'required'],
            [['project'], 'integer'],
            [['title', 'filename'], 'string', 'max' => 255],
            [['guide_text'], 'string'],
            [['title'], 'unique'],
            [['category_ids'], 'each', 'rule' => [
                'exist', 'targetClass' => Category::className(), 'targetAttribute' => 'id', 'message' => Yii::t('guide','This category does not exist'),
            ]],
            [['project'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'title' => Yii::t('guide', 'Title'),
            'filename' => Yii::t('guide', 'Filename'),
            'category_ids' => Yii::t('guide', 'Categories'),
            'project' => Yii::t('project', 'Project'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject0()
    {
        return $this->hasOne(Project::className(), ['id' => 'project']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories() {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('guides_categories', ['guide_id' => 'id']);
    }

    /**
     * @return string
     */
    public function renderGuide()
    {
        if(file_exists($this->filepath)) {
            return Markdown::convert(file_get_contents($this->filepath), [
                'smartyPants' => false,
            ],Markdown::SMARTYPANTS_ATTR_DO_NOTHING);
        } else {
            return '<p style="color:red;">'.Yii::t('guide', 'This guide\'s file is not found, you might as well delete this guide').'</p>';
        }
    }

    public function getFilePath() {
        if(!empty($this->filename)) {
            return Yii::getAlias('@frontend').'/guides/'.$this->filename;
        } else {
            return null;
        }
    }

    /**
     * Saves the guide text gives in file and removes the old file if present
     * @param $guide_text
     * @return bool true if file is saved otherwise false
     */
    private function saveGuideFile($guide_text)
    {
        $this->deleteGuideFile();
        $filename = substr(hash('md5',time()),0,8).'.md';
        $filepath = Yii::getAlias('@frontend').'/guides/'.$filename;
        if(file_put_contents($filepath, $guide_text)) {
            $this->filename = $filename;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Deletes the file associated with this Guide
     * @return bool
     */
    private function deleteGuideFile()
    {
        if(!empty($this->filename) && file_exists($this->filepath)) {
            return unlink($this->filepath);
        }
        return true;
    }

    /**
     * Renders the categories from this Guide as labels
     * @param $fontSize int The fontsize of the label
     * @return string The categories as labels in html
     */
    public function renderCategories($fontSize = null)
    {
        $html = "";
        $fontSize = (is_numeric($fontSize)) ? "style=\"font-size: {$fontSize};\"" : '';
        foreach($this->categories as $category) {
            $html .= "<div {$fontSize} class=\"label label-primary\">{$category->name}</div>";
        }
        return $html;
    }

    public function getRenderCategories() {
        return $this->renderCategories(12);
    }

}

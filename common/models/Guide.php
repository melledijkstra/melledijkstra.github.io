<?php

namespace common\models;

use common\components\db\MActiveRecord;
use common\components\Linkable;
use kartik\markdown\Markdown;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "guides".
 *
 * @property integer $id
 * @property string $title
 * @property string $filename
 * @property string $filepath
 * @property integer $project_id
 * @property integer $difficulty
 * @property integer $duration
 *
 * @property Project $project
 * @property Language $language
 * @property Category[] $categories
 */
class Guide extends MActiveRecord implements Linkable
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

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if(parent::beforeValidate()) {
            $this->createUnknownCategories();
            return true;
        };
        return false;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert) && $this->saveGuideFile($this->guide_text)) {
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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
            [['project_id', 'language_id', 'difficulty', 'duration'], 'integer'],
            [['title', 'filename'], 'string', 'max' => 255],
            [['guide_text'], 'string'],
            [['title'], 'unique'],
            [['category_ids'], 'each', 'rule' => [
                'exist', 'targetClass' => Category::className(), 'targetAttribute' => 'id', 'message' => Yii::t('guide','This category does not exist'),
            ]],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
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
            'project_id' => Yii::t('project', 'Project'),
            'difficulty' => Yii::t('guide', 'Difficulty'),
            'duration' => Yii::t('guide', 'Duration'),
            'language_id' => Yii::t('guide', 'Programming Language'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories() {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('guides_categories', ['guide_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage() {
       return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuidesCategories() {
        return $this->hasMany(GuidesCategory::className(), ['guide_id' => 'id']);
    }

    /**
     * @return string
     */
    public function renderGuide()
    {
        if(file_exists($this->filepath)) {
            return Markdown::convert(file_get_contents($this->filepath), [
                'smartyPants' => false,
            ], Markdown::SMARTYPANTS_ATTR_DO_NOTHING);
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
            $html .= "<div {$fontSize} class=\"label label-primary\">{$category->name}</div> ";
        }
        return $html;
    }

    public function getRenderCategories() {
        return $this->renderCategories(12);
    }

    /**
     * Returns the title of this guide
     * @param bool $withDashes If the guide title should use dashes instead of spaces, this is used for links to this guide
     * @return mixed|string The title with or without dashes
     */
    public function getTitle($withDashes = false) {
        if($withDashes) return str_replace(' ','-',$this->title);
        return $this->title;
    }

    /**
     * @inheritdoc
     */
    public function getLink()
    {
        return Url::to('/guides/'.$this->getTitle(true));
    }

    /**
     * Creates any categories which don't exist in category list
     */
    private function createUnknownCategories()
    {
        // Go though every category
        for($i = 0;$i < count($this->category_ids);$i++) {
            // if the category is not a number then it doesn't exist yet
            if(!is_numeric($this->category_ids[$i])) {
                // create the new category
                $cat = new Category(['name' => $this->category_ids[$i]]);
                if($cat->save()) {
                    // if it saves correctly override the spot with the new id
                    $this->category_ids[$i] = $cat->id;
                }
            }
        }
    }
}

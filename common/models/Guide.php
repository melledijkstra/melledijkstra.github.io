<?php

namespace common\models;

use kartik\markdown\Markdown;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "guides".
 *
 * @property integer $id
 * @property string $title
 * @property string $filename
 * @property string $filepath
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $project
 *
 * @property Project $project0
 * @property User $createdBy
 * @property User $updatedBy
 */
class Guide extends ActiveRecord
{

    /**
     * @var $guide_text string This is the markdown entered by a user which needs to be saved to a file
     */
    public $guide_text;

    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guides';
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert) && $this->saveGuide($this->guide_text)) {
            return true;
        }
        return false;
    }

    public function beforeDelete()
    {
        if(parent::beforeDelete()) {
            // Delete the file before deleting guide from database
            return $this->deleteGuideFile();
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        if(file_exists($this->filepath)) {
            $this->guide_text = file_get_contents($this->filepath);
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
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'project'], 'integer'],
            [['title', 'filename'], 'string', 'max' => 255],
            [['guide_text'], 'string'],
            [['title'], 'unique'],
            [['project'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
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
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
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
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return string
     */
    public function renderGuide()
    {
        if(file_exists($this->filepath)) {
            return Markdown::convert(file_get_contents($this->filepath));
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
    private function saveGuide($guide_text)
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
}

<?php

namespace common\models;

use kartik\markdown\Markdown;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "guides".
 *
 * @property integer $id
 * @property string $title
 * @property string $filename
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



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guides';
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            if($insert) {
                $filename = Yii::getAlias('@frontend').'/guides/'.hash('md5',time()).'.md';
                file_put_contents($filename,$this->guide_text);
                $this->filename = $filename;
            } else {
                // remove older file

                // create new markdown file
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'filename', 'guide_text'], 'required'],
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
    public function getGuide()
    {
        return Markdown::convert(file_get_contents($this->filename));
    }
}

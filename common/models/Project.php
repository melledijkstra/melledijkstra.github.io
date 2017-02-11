<?php

namespace common\models;

use common\components\db\FileUploadActiveRecord;
use Yii;

/**
 * This is the model class for table "projects".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $thumbnail
 * @property string $external_url
 */
class Project extends FileUploadActiveRecord
{

    /**
     * Overridden allowed extensions
     * @var array
     */
    protected $extensions = ['png', 'jpg', 'png', 'jpeg'];

    /**
     * Overridden attribute name for the column name
     * @var string
     */
    protected $fileAttributeName = 'thumbnail';

    /**
     * Overridden attribute so that file isn't required
     * @var bool
     */
    protected $fileRequired = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge_recursive(parent::rules(),[
            [['title'], 'required'],
            [['title', 'description', 'thumbnail', 'external_url'], 'string', 'max' => 255],
            [['title'], 'unique'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'title' => Yii::t('common', 'Title'),
            'description' => Yii::t('project', 'Description'),
            'thumbnail' => Yii::t('project', 'Thumbnail'),
            'external_url' => Yii::t('project', 'External Url'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuides()
    {
        return $this->hasMany(Guide::className(), ['project' => 'id']);
    }

    /**
     * Generate thumbnail link
     */
    public function getPublicLink()
    {
        if(!empty($this->thumbnail) && file_exists(self::$uploadFolder.$this->thumbnail)) {
            return '/uploads/'.$this->tableName().'/'.$this->thumbnail;
        } else {
            return 'http://placehold.it/250x200';
        }
    }
}

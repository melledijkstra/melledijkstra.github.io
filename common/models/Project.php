<?php

namespace common\models;

use common\components\db\ImageUploadActiveRecord;
use common\components\Linkable;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * This is the model class for table "projects".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $thumbnail
 * @property string $external_url
 *
 * @property string $link
 * @property Guide[] $guides
 */
class Project extends ImageUploadActiveRecord implements Linkable
{

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
     * @var int The width of the image
     */
    protected $width = 600;

    /**
     * @var int The height of the image
     */
    protected $height = 600;

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
            [['title'], 'match', 'pattern' => '/^[a-zA-Z0-9_ -]*$/'],
            [['title', 'description', 'thumbnail', 'external_url'], 'string', 'max' => 255],
            [['title'], 'unique'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),[
            'title' => Yii::t('common', 'Title'),
            'description' => Yii::t('project', 'Description'),
            'thumbnail' => Yii::t('project', 'Thumbnail'),
            'external_url' => Yii::t('project', 'External Url'),
        ]);
    }

    /**
     * @return ActiveQuery
     */
    public function getGuides(): ActiveQuery
    {
        return $this->hasMany(Guide::className(), ['project_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getPublicLink($absolute = false): string
    {
        if(!empty($this->thumbnail) && file_exists(self::$uploadPath.$this->thumbnail)) {
            $url = $absolute ? Url::base(true) : '';
            return $url.'/uploads/'. static::tableName().'/'.$this->thumbnail;
        }

        return 'http://placehold.it/250x200';
    }

    /**
     * Returns the title of this project
     * @param bool $slug If the project title should use dashes and lowercase instead of spaces, this is used for links to this project
     * @return mixed|string The title with or without dashes
     */
    public function getTitle($slug = false) {
        if($slug) {
            return strtolower(str_replace(' ', '-', $this->title));
        }
        return $this->title;
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidParamException
     */
    public function getLink()
    {
        return Url::to('/portfolio/'.$this->getTitle(true));
    }

}

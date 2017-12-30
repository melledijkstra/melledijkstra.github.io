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
 * @property int $size [int(11)]
 * @property string $external_url
 * @property string $externalUrl
 *
 * @property Guide[] $guides
 * @property string $credits [varchar(255)]
 */
class Project extends ImageUploadActiveRecord implements Linkable
{

    /**
     * Overridden attribute name for the column name
     * @var string
     */
    protected static $fileAttributeName = 'thumbnail';

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
     * @var array The different sizes for a project
     */
    const SIZES = [
        'Small',
        'Large',
        'Landscape',
        'Portrait',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'projects';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_merge_recursive(parent::rules(),[
            [['title'], 'required'],
            [['size'], 'integer'],
            [['external_url'], 'url', 'defaultScheme' => 'http'],
            [['title'], 'match', 'pattern' => '/^[a-zA-Z0-9_ -]*$/'],
            [['title', 'description', 'thumbnail', 'external_url'], 'string', 'max' => 255],
            [['title'], 'unique'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return array_merge(parent::attributeLabels(),[
            'title' => Yii::t('common', 'Title'),
            'description' => Yii::t('project', 'Description'),
            'thumbnail' => Yii::t('project', 'Thumbnail'),
            'size' => Yii::t('project', 'Size'),
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
    public function getPublicLink($absolute = false, $fromBackend = false): string
    {
        if(!empty($this->thumbnail) && file_exists(static::$uploadPath.$this->thumbnail)) {
            $url = '';
            if($absolute) {
                if($fromBackend) {
                    $url = \Yii::$app->params['frontendUrl'];
                } else {
                    $url = Url::base(true);
                }
            }
            return $url.'/uploads/'. static::tableName().'/'.$this->thumbnail;
        }

        return 'http://placehold.it/250x200';
    }

    /**
     * Returns the title of this project
     * @param bool $slug If the project title should use dashes and lowercase instead of spaces, this is used for links to this project
     * @return string The title with or without dashes
     */
    public function getTitle($slug = false): string
    {
        if($slug) {
            return strtolower(str_replace(' ', '-', $this->title));
        }
        return $this->title;
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidParamException
     */
    public function getLink($absolute = false): string
    {
        return Url::to('/portfolio/'.$this->getTitle(true));
    }

    /**
     * Retrieve the external URL of this project
     * @throws \yii\base\InvalidParamException
     */
    public function getExternalUrl(): string
    {
        $url = Url::isRelative($this->external_url) ? 'http://'.$this->external_url : $this->external_url;
        return $url;
    }

    /**
     * @return string
     */
    public function getSizeString(): string
    {
        return static::SIZES[$this->size];
    }

    /**
     * Check if project has an url defined
     * @return bool
     */
    public function hasUrl(): bool
    {
        return !empty($this->external_url);
    }

}

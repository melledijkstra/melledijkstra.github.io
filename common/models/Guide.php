<?php

namespace common\models;

use common\components\db\ImageUploadActiveRecord;
use common\components\Linkable;
use kartik\markdown\Markdown;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "guides".
 *
 * @property integer $id
 * @property string $title
 * @property string $sneak_peek
 * @property string $filename
 * @property string $filepath
 * @property integer $project_id
 * @property integer $language_id
 * @property integer $difficulty
 * @property integer $duration
 *
 * @property Project $project
 * @property Language $language
 * @property Category[] $categories
 * @property ActiveQuery $guidesCategories
 * @property Guide $previousGuide
 * @property null|string $filePath
 * @property Guide $nextGuide
 * @property string[] $categoryStrings
 * @property string $thumbnail
 * @property string $credits [varchar(255)]
 */
class Guide extends ImageUploadActiveRecord implements Linkable
{

    /** The maximum difficulty a guide can get */
    const MAX_DIFFICULTY = 5;

    /** @var $guideText string This is the markdown entered by a user or retrieved from linked file */
    public $guideText;

    /** @var array The linked categories */
    public $categoryIds = [];

    protected static $fileAttributeName = 'thumbnail';

    protected $height = 400;

    protected $width = 650;

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'guides';
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->createUnknownCategories();
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidParamException
     */
    public function beforeSave($insert): bool
    {
        return parent::beforeSave($insert) && $this->saveGuideFile($this->guideText);
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidCallException
     */
    public function afterSave($insert, $changedAttributes)
    {
        GuidesCategory::deleteAll(['guide_id' => $this->id]);
        if (\is_array($this->categoryIds)) {
            foreach ($this->categoryIds as $category_id) {
                $this->link('categories', Category::findOne($category_id));
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            // Delete the file before deleting guide from database
            $this->deleteGuideFile();
            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        if (file_exists($this->filepath)) {
            $this->guideText = file_get_contents($this->filepath);
        }
        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['title', 'guideText'], 'required'],
            [['project_id', 'language_id', 'difficulty', 'duration'], 'integer'],
            [['title', 'filename', 'thumbnail'], 'string', 'max' => 255],
            [['sneak_peek'], 'string', 'max' => 700],
            [['guideText', 'credits'], 'string'],
            [['title'], 'unique'],
            [['title'], 'match', 'pattern' => '/^[a-zA-Z0-9_ ]*$/'],
            [
                ['categoryIds'],
                'each',
                'rule' => [
                    'exist',
                    'targetClass' => Category::className(),
                    'targetAttribute' => 'id',
                    'message' => Yii::t('guide', 'This category does not exist'),
                ]
            ],
            [
                ['project_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Project::className(),
                'targetAttribute' => ['project_id' => 'id']
            ],
            [
                ['language_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Language::className(),
                'targetAttribute' => ['language_id' => 'id']
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'title' => Yii::t('guide', 'Title'),
            'sneak_peek' => Yii::t('guide', 'Sneak Peek'),
            'filename' => Yii::t('guide', 'Filename'),
            'categoryIds' => Yii::t('guide', 'Categories'),
            'project_id' => Yii::t('project', 'Project'),
            'difficulty' => Yii::t('guide', 'Difficulty'),
            'duration' => Yii::t('guide', 'Duration'),
            'language_id' => Yii::t('guide', 'Programming Language'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProject(): ActiveQuery
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('guides_categories',
            ['guide_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getCategoryIds(): array
    {
        if (empty($this->categoryIds)) {
            foreach ($this->categories as $category) {
                $this->categoryIds[] = $category->id;
            }
        }
        return $this->categoryIds;
    }

    /**
     * @return ActiveQuery
     */
    public function getLanguage(): ActiveQuery
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @return GuidesCategory[]|ActiveQuery
     */
    public function getGuidesCategories(): ActiveQuery
    {
        return $this->hasMany(GuidesCategory::className(), ['guide_id' => 'id']);
    }

    /**
     * Retrieves the previous guide in the series
     * @return ActiveQuery
     */
    public function getPreviousGuide(): ActiveQuery
    {
        /**
         * SELECT
         * guides.*
         * FROM
         * series_guides sg
         * JOIN
         * (-- We get the current `series_id`, `ord`, based on `guide_id`
         * SELECT series_id, `order`
         * FROM series_guides sg
         * WHERE guide_id = 13
         * ) AS nextsg
         * -- We want to be in the same series_id, but greater ord
         * ON sg.series_id = nextsg.series_id AND sg.`order` > nextsg.`order`
         * JOIN guides ON sg.guide_id = guides.id
         * ORDER BY sg.`order`LIMIT 1;
         */

//        self::find()->joinWith([
//            'series_guides' => function($q) {
//                /** @var $q ActiveQuery */
//                $q->alias('nextsg');
//            }
//        ])->limit(1);

        return self::findBySql('SELECT
  guides.*
FROM
  series_guides sg
  JOIN
  (-- We get the current `series_id`, `order`, based on `guide_id`
    SELECT guide_id, series_id, `order`
    FROM series_guides sg
    WHERE guide_id = :guide_id
  ) AS prevsg
  -- We want to be in the same series_id, but greater order
    ON sg.series_id = prevsg.series_id AND sg.`order` < prevsg.`order`
  JOIN guides ON sg.guide_id = guides.id
ORDER BY sg.`order` DESC LIMIT 1;', ['guide_id' => $this->id]);
    }

    /**
     * Retrieves the next guide in the series
     * @return ActiveQuery
     */
    public function getNextGuide(): ActiveQuery
    {
        /**
         * SELECT
         * guides.*
         * FROM
         * series_guides sg
         * JOIN
         * (-- We get the current `series_id`, `ord`, based on `guide_id`
         * SELECT series_id, `order`
         * FROM series_guides sg
         * WHERE guide_id = 13
         * ) AS nextsg
         * -- We want to be in the same series_id, but greater ord
         * ON sg.series_id = nextsg.series_id AND sg.`order` > nextsg.`order`
         * JOIN guides ON sg.guide_id = guides.id
         * ORDER BY sg.`order`LIMIT 1;
         */

//        self::find()->joinWith([
//            'series_guides' => function($q) {
//                /** @var $q ActiveQuery */
//                $q->alias('nextsg');
//            }
//        ])->limit(1);

        return self::findBySql('SELECT
  guides.*
FROM
  series_guides sg
  JOIN
  (-- We get the current `series_id`, `ord`, based on `guide_id`
    SELECT series_id, `order`
    FROM series_guides sg
    WHERE guide_id = :guide_id
  ) AS nextsg
  -- We want to be in the same series_id, but greater ord
    ON sg.series_id = nextsg.series_id AND sg.`order` > nextsg.`order`
  JOIN guides ON sg.guide_id = guides.id
ORDER BY sg.`order` ASC LIMIT 1;', ['guide_id' => $this->id]);
    }

    /**
     * @return string
     */
    public function renderGuide(): string
    {
        try {
            if (file_exists($this->filepath)) {
                return Markdown::convert(file_get_contents($this->filepath), [
                    'smartyPants' => false,
                ], Markdown::SMARTYPANTS_ATTR_DO_NOTHING);
            }
        } catch (InvalidConfigException $e) {
        }

        return '<p style="color:red;">' . Yii::t('guide', 'This guide\'s file is not found!') . '</p>';
    }

    /**
     * @return string|null
     * @throws \yii\base\InvalidParamException
     */
    public function getFilePath()
    {
        if (!empty($this->filename)) {
            return \Yii::getAlias('@frontend') . '/guides/' . $this->filename;
        }

        return null;
    }

    public function getImageFilePath()
    {

    }

    /**
     * Saves the guide text gives in file and removes the old file if present
     * @param $guide_text
     * @return bool true if file is saved otherwise false
     * @throws \yii\base\InvalidParamException
     */
    private function saveGuideFile($guide_text): bool
    {
        $this->deleteGuideFile();
        $filename = $this->getTitle(true) . '_' . time() . '.md'; // example filename: guide-title_12343827.md
        $filepath = \Yii::getAlias('@frontend') . '/guides/' . $filename;
        if (file_put_contents($filepath, $guide_text)) {
            $this->filename = $filename;
            return true;
        }

        return false;
    }

    /**
     * Deletes the file associated with this Guide
     * @return bool
     */
    private function deleteGuideFile(): bool
    {
        if (!empty($this->filename) && file_exists($this->filepath)) {
            return unlink($this->filepath);
        }
        return true;
    }

    /**
     * Returns the categories as string in a list
     * @return array The categories as labels in html
     */
    public function getCategoryStrings(): array
    {
        $categories = [];
        foreach ($this->categories as $category) {
            $categories[] = $category->name;
        }
        return $categories;
    }

    /**
     * Returns the title of this guide
     * @param bool $slug If the guide title should use dashes instead of spaces, this is used for links to this guide
     * @return mixed|string The title with or without dashes
     */
    public function getTitle($slug = false)
    {
        if ($slug) {
            return strtolower(str_replace(' ', '-', $this->title));
        }
        return $this->title;
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidParamException
     */
    public function getLink($absolute = false, $fromBackend = false): string
    {
        $url = $fromBackend ? \Yii::$app->params['frontendUrl'] : '';
        $url .= Url::to('/guides/' . $this->getTitle(true), $fromBackend ? false : $absolute);
        return $url;
    }

    /**
     * Creates any categories which don't exist in category list
     */
    private function createUnknownCategories()
    {
        // Go though every category
        if (\is_array($this->categoryIds)) {
            foreach ($this->categoryIds as $i => $value) {
                // if the category is not a number then it doesn't exist yet
                if (!is_numeric($this->categoryIds[$i])) {
                    // create the new category
                    $cat = new Category(['name' => $this->categoryIds[$i]]);
                    if ($cat->save()) {
                        // if it saves correctly override the spot with the new id
                        $this->categoryIds[$i] = $cat->id;
                    }
                }
            }
        }
    }

    /**
     * Generate list of difficulties which are available
     */
    public static function difficultyList()
    {
        $list = [];
        for ($i = 1; $i <= static::MAX_DIFFICULTY; $i++) {
            $list[$i] = $i;
        }
        return $list;
    }

    /**
     * Checks if this guide has an image
     * @return bool whether guide has image or not
     */
    public function hasImage(): bool
    {
        return ($this->thumbnail !== null);
    }
}

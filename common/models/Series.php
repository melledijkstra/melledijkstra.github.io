<?php

namespace common\models;

use common\components\db\ImageUploadActiveRecord;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "series".
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 *
 * @property Guide[] $guides
 * @property SeriesGuides[] $seriesGuides
 */
class Series extends ImageUploadActiveRecord
{

    /** @var array The linked guide ids which are filled upon creation/updating */
    public $guideIds = [];

    /** @var string  */
    protected $fileAttributeName = 'image';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'series';
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        // When updating first delete all links
        if(!$insert) SeriesGuides::deleteAll(['series_id' => $this->id]);
        $order = 1;
        foreach($this->guideIds as $guideId) {
            $this->link('guides', Guide::findOne((int)$guideId), ['order' => $order]);
            ++$order;
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        foreach($this->seriesGuides as $seriesGuide) {
            $this->guideIds[] = $seriesGuide->guide_id;
        }
        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['image'], 'unique'],
            [['guideIds'], 'each', 'rule' => [
                'exist', 'targetClass' => SeriesGuides::className(), 'targetAttribute' => 'guide_id',
                'message' => Yii::t('series', 'The guide with id {value} is already in a series')
            ]],
            [['guideIds'], 'each', 'rule' => [
                'exist', 'targetClass' => Guide::className(), 'targetAttribute' => 'id',
                'message' => Yii::t('series','This guide does not exist'),
            ]],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'title' => Yii::t('series', 'Title'),
            'image' => Yii::t('series', 'Image'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeriesGuides()
    {
        return $this->hasMany(SeriesGuides::className(), ['series_id' => 'id'])->orderBy('order');
    }

    /**
     * @return Guide[]|\yii\db\ActiveQuery
     */
    public function getGuides() {
        return $this->hasMany(Guide::className(), ['id' => 'guide_id'])->viaTable('series_guides', ['series_id' => 'id'], function($query) {
            /** @var $query ActiveQuery */
            $query->orderBy(['order' => SORT_ASC]);
        });
    }
}

<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "series_guides".
 *
 * @property integer $series_id
 * @property integer $guide_id
 * @property integer $order
 *
 * @property Guide $guide
 * @property Series $series
 */
class SeriesGuides extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'series_guides';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['series_id', 'guide_id', 'order'], 'required'],
            [['series_id', 'guide_id', 'order'], 'integer'],
            [['guide_id'], 'unique'],
            [['guide_id'], 'exist', 'skipOnError' => true, 'targetClass' => Guide::className(), 'targetAttribute' => ['guide_id' => 'id']],
            [['series_id'], 'exist', 'skipOnError' => true, 'targetClass' => Series::className(), 'targetAttribute' => ['series_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'series_id' => Yii::t('series', 'Series'),
            'guide_id' => Yii::t('guide', 'Guide'),
            'order' => Yii::t('series', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuide()
    {
        return $this->hasOne(Guide::className(), ['id' => 'guide_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeries()
    {
        return $this->hasOne(Series::className(), ['id' => 'series_id']);
    }
}

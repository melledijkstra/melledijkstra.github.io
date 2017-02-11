<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "guides_categories".
 *
 * @property integer $guide_id
 * @property integer $category_id
 *
 * @property Categories $category
 * @property Guides $guide
 */
class GuidesCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guides_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guide_id', 'category_id'], 'required'],
            [['guide_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['guide_id'], 'exist', 'skipOnError' => true, 'targetClass' => Guides::className(), 'targetAttribute' => ['guide_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'guide_id' => Yii::t('guide', 'Guide ID'),
            'category_id' => Yii::t('guide', 'Category ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuide()
    {
        return $this->hasOne(Guides::className(), ['id' => 'guide_id']);
    }
}

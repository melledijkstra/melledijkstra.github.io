<?php

namespace common\models;

use common\components\db\MActiveRecord;
use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Guide[] $guides
 */
class Category extends MActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('category', 'ID'),
            'name' => Yii::t('category', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuides()
    {
        return $this->hasMany(Guide::className(), ['id' => 'guide_id'])->viaTable('guides_categories', ['category_id' => 'id']);
    }
}

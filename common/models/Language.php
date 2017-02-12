<?php

namespace common\models;

use common\components\db\MActiveRecord;
use Yii;

/**
 * This is the model class for table "languages".
 *
 * @property integer $id
 * @property string $name
 * @property string $color
 *
 * @property Guide[] $guides
 */
class Language extends MActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'color'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('language', 'Name'),
            'color' => Yii::t('language', 'Color'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuides()
    {
        return $this->hasMany(Guide::className(), ['language_id' => 'id']);
    }
}

<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Guide;

/**
 * GuideSearch represents the model behind the search form about `common\models\Guide`.
 */
class GuideSearch extends Guide
{

    public $category_id;

    public $content;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'project_id', 'category_id', 'language_id', 'difficulty', 'duration'], 'integer'],
            [['title', 'content'], 'string'],
            [['title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function formName(): string
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return array_merge(parent::attributeLabels(), [
            'content'       => Yii::t('guide-search', 'Title & Description'),
            'category_id'   => Yii::t('guide-search', 'Category'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidParamException
     */
    public function search($params): ActiveDataProvider
    {
        // Always sort by the newest Guides
        $query = Guide::find()->orderBy(['created_at' => SORT_DESC]);

        $query->joinWith('guidesCategories');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if(!$this->load($params) && $this->validate()) {
            return $dataProvider;
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'project_id'                    => $this->project_id,
            'difficulty'                    => $this->difficulty,
            'duration'                      => $this->duration,
            'language_id'                   => $this->language_id,
            'guides_categories.category_id' => $this->category_id,
            'created_at'                    => $this->created_at,
            'updated_at'                    => $this->updated_at,
            'created_by'                    => $this->created_by,
            'updated_by'                    => $this->updated_by,
        ]);

        $query->andFilterWhere(['or',
            ['like', 'guides.title', $this->content],
            ['like', 'guides.sneak_peek', $this->content],
        ]);

        return $dataProvider;
    }
}

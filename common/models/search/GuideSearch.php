<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Guide;

/**
 * GuideSearch represents the model behind the search form about `common\models\Guide`.
 */
class GuideSearch extends Guide
{

    public $category_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'filename'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
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
     */
    public function search($params)
    {
        // Always sort by the newest Guides
        $query = Guide::find()->orderBy(['created_at' => SORT_DESC]);

        $query->joinWith('guidesCategories');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //die(var_dump($params));

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
            'project_id' => $this->project_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['guides_categories.category_id' => $this->category_id]);

        $query->andFilterWhere(['like', 'guides.title', $this->title]);

        return $dataProvider;
    }
}

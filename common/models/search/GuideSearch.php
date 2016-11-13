<?php

namespace common\models\search;

use common\models\Project;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Guide;

/**
 * GuideSearch represents the model behind the search form about `common\models\Guide`.
 */
class GuideSearch extends Guide
{

    public $project;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['project'], 'string'],
            [['title', 'filename', 'project'], 'safe'],
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
        $query = Guide::find();

        // add conditions that should always apply here
        // Joining projects so user can search on project title
        $query->joinWith('project0');

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'filename', $this->filename]);

        $query->andFilterWhere(['like', 'projects.title', $this->project]);

        return $dataProvider;
    }
}

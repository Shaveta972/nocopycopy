<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ScanRecords;

/**
 * ScanSearch represents the model behind the search form of `app\models\ScanRecords`.
 */
class ScanSearch extends ScanRecords
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'number_copied_words'], 'integer'],
            [['process_id', 'url', 'title', 'introduction', 'percents', 'cached_version'], 'safe'],
        ];
    }


	public function beforeValidate(){
    	return true;
    }

    /**
     * {@inheritdoc}
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
        $query = ScanRecords::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'number_copied_words' => $this->number_copied_words,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'isDeleted' => $this->isDeleted,
        ]);

        $query->andFilterWhere(['like', 'process_id', $this->process_id])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'introduction', $this->introduction])
            ->andFilterWhere(['like', 'percents', $this->percents])
            ->andFilterWhere(['like', 'cached_version', $this->cached_version]);

        return $dataProvider;
    }
}

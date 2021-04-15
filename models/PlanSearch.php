<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Plans;

/**
 * PlanSearch represents the model behind the search form of `app\models\Plans`.
 */
class PlanSearch extends Plans
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_category_id', 'price', 'validity'], 'integer'],
            [['title', 'number_credits'], 'safe'],
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
        $query = Plans::find();

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
            'user_category_id' => $this->user_category_id,
            'price' => $this->price,
            'validity' => $this->validity,
            'isDeleted' => Yii::t('app', 'Is Deleted'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'created_at' => Yii::t('app', 'Created On'),
            'updated_at' => Yii::t('app', 'Updated On'),
            'created_by' => Yii::t('app', 'Created By')
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'number_credits', $this->number_credits]);

        return $dataProvider;
    }
}

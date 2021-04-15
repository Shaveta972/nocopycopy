<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CreditScanSettings;

/**
 * CreditScanSearch represents the model behind the search form of `app\models\CreditScanSettings`.
 */
class CreditScanSearch extends CreditScanSettings
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'credit_value'], 'integer'],
            [['doc_type'], 'safe'],
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
        $query = CreditScanSettings::find();

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
            'credit_value' => $this->credit_value,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'isDeleted' => $this->isDeleted,
        ]);

        $query->andFilterWhere(['like', 'doc_type', $this->doc_type]);

        return $dataProvider;
    }
}

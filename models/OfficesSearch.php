<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Offices;

/**
 * OfficesSearch represents the model behind the search form about `app\models\Offices`.
 */
class OfficesSearch extends Offices
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_office', 'id_address'], 'integer'],
            [['title_office'], 'safe'],
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
        $query = Offices::find();

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
            'id_office' => $this->id_office,
            'id_address' => $this->id_address,
        ]);

        $query->andFilterWhere(['like', 'title_office', $this->title_office]);

        return $dataProvider;
    }
}

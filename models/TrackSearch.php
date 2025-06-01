<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;

class TrackSearch extends Track
{
    public function rules(): array
    {
        return [
            ['id', 'integer'],
            ['track_number', 'string'],
            ['status', 'in', 'range' => array_keys(static::getStatusList())],
        ];
    }

    public function search($params): DataProviderInterface
    {
        $query = Track::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['LIKE', 'track_number', $this->track_number]);
        $query->andFilterWhere(['status' => $this->status]);

        return $dataProvider;
    }
}
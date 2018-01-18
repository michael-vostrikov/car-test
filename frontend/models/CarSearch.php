<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Car;

/**
 * CarSearch represents the model behind the search form of `common\models\Car`.
 */
class CarSearch extends \yii\base\Model
{
    public $categoryId;
    public $priceFrom;
    public $priceTo;
    public $yearFrom;
    public $yearTo;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoryId', 'priceFrom', 'priceTo', 'yearFrom', 'yearTo'], 'integer'],
            ['categoryId', 'in', 'range' => array_keys(Car::getCategoryList())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categoryId' => Yii::t('app', 'Модельный ряд'),
            'priceFrom' => Yii::t('app', 'Цена от'),
            'priceTo' => Yii::t('app', 'Цена до'),
            'yearFrom' => Yii::t('app', 'Год от'),
            'yearTo' => Yii::t('app', 'Год до'),
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
        $query = Car::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['price', 'created_at']],
        ]);

        // add default sort without icon in interface
        if (empty($dataProvider->sort->getAttributeOrders())) {
            $query->orderBy(['created_at' => SORT_DESC]);
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere(['categoryId' => $this->categoryId]);

        $query->andFilterWhere(['>=', 'price', $this->priceFrom]);
        $query->andFilterWhere(['<=', 'price', $this->priceTo]);
        $query->andFilterWhere(['>=', 'year', $this->yearFrom]);
        $query->andFilterWhere(['<=', 'year', $this->yearTo]);

        return $dataProvider;
    }
}

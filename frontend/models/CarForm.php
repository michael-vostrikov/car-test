<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Car;

/**
 * CarForm represents the model for Car create/update form
 *
 * @property integer $categoryId
 * @property integer $status
 * @property string  $title
 * @property string  $image
 * @property integer $price
 * @property integer $year
 * @property string  $url
 */
class CarForm extends \yii\base\Model
{
    /** @var Car */
    public $model;

    public $categoryId;
    public $status;
    public $title;
    public $image;
    public $price;
    public $year;
    public $url;

    public function __construct(Car $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'categoryId', 'price', 'year'], 'integer'],
            [['title', 'image', 'url'], 'string', 'max' => 255],
            [['url'], 'required'],
            [['url'], 'unique', 'targetClass' => Car::class],
            ['categoryId', 'in', 'range' => array_keys(Car::getCategoryList())],
            ['status', 'in', 'range' => array_keys(Car::getStatusList())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'status' => Yii::t('app', 'Статус'),
            'title' => Yii::t('app', 'Название'),
            'image' => Yii::t('app', 'Изображение'),
            'categoryId' => Yii::t('app', 'Модельный ряд'),
            'price' => Yii::t('app', 'Цена'),
            'url' => Yii::t('app', 'Ссылка на страницу'),
            'year' => Yii::t('app', 'Год выпуска'),

            'imageFile' => Yii::t('app', 'Изображение'),
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
     * @inheritdoc
     */
    public function save()
    {
        $res = ($this->model->load($this->getAttributes(), '') && $this->model->save());
        if ($res === false) {
            $this->addErrors($this->model->getErrors());
        }

        return $res;
    }
}

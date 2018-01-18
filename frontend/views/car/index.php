<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Car;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cars');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p class="text-right">
        <?= Html::a(Yii::t('app', 'Create Car'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_search', ['model' => $searchModel]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['attribute' => 'categoryId', 'value' => function($model) {
                return (Car::getCategoryList()[$model->categoryId] ?? null);
            }],
            'title',
            'image',
            'year',
            'price',
            'created_at:datetime',
            ['attribute' => 'status', 'value' => function($model) {
                return (Car::getStatusList()[$model->status] ?? null);
            }],

            ['class' => 'yii\grid\ActionColumn', 'urlCreator' => function ($action, $model) {
                return ([
                    'view' => ['car/view', 'url' => $model->url],
                    'update' => ['car/update', 'id' => $model->id],
                    'delete' => ['car/delete', 'id' => $model->id],
                ][$action] ?? null);
            }],
        ],
    ]); ?>
</div>

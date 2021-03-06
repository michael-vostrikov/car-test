<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Car;

/* @var $this yii\web\View */
/* @var $model common\models\Car */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['attribute' => 'categoryId', 'value' => function($model) {
                return (Car::getCategoryList()[$model->categoryId] ?? null);
            }],
            'title',
            ['attribute' => 'image', 'format' => 'raw', 'value' => function ($model) {
                $relPath = $model->getImageRelativePath();
                if (!$relPath) {
                    return null;
                }

                $url = Yii::getAlias('@web' . $model->getImageRelativePath());
                return Html::a(Html::img($url, ['width' => '200']), $url, ['target' => '_blank']);
            }],
            'url',
            'price',
            'year',
            ['attribute' => 'status', 'value' => function($model) {
                return (Car::getStatusList()[$model->status] ?? null);
            }],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>

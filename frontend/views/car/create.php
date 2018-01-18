<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\CarForm */

$this->title = Yii::t('app', 'Create Car Card');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

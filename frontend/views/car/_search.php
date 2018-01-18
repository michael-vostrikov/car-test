<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CarSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="car-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-2">
            <?= $form->field($model, 'categoryId')->dropDownList(\common\models\Car::getCategoryList(), ['prompt' => '']) ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'priceFrom') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'priceTo') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'yearFrom') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'yearTo') ?>
        </div>
        <div class="col-sm-2 text-right">
            <div class="form-group">
                <div><label>&nbsp;</label></div>
                <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Car;

/* @var $this yii\web\View */
/* @var $model frontend\models\CarForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="car-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'categoryId')->dropDownList(Car::getCategoryList(), ['prompt' => '']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(Car::getStatusList(), ['prompt' => '']) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

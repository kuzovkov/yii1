<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Forecast */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="forecast-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?=$form->field($model, 'file')->fileInput(); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Import'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

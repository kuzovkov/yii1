<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php if ($name):?> You entered name <b><?=$name ?></b> and email <b><?=$email?></b><?php endif;?>
<?php $f = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $f->field($form, 'name') ?>
    <?= $f->field($form, 'email') ?>
    <?= $f->field($form, 'file')->fileInput(); ?>
    <?= Html::submitButton('Submit') ?>
<?php ActiveForm::end(); ?>


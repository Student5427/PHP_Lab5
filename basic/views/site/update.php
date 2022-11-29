<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['id' => 'login-form', 'options' =>['class' => 'horizontal', 'enctype'=>'multipart/form-data'], 'method' => 'post']);

?>

<?= $form->field($image, 'name')->fileInput()?>

<?= $form->field($image, 'caption')->textInput()?>

<?= Html::submitButton('Save', ['class' => 'btn btn-primary'])?>

<?php ActiveForm::end() ?>

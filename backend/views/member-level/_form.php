<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MemberLevel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-level-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'level_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bottom_num')->textInput() ?>

    <?= $form->field($model, 'top_num')->textInput() ?>

    <?= $form->field($model, 'rate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

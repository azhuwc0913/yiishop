<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([0 => '限制管理员登录',10=>'允许管理员登录'], ['prompt'=>'请选择', 'style'=>'width:150px']) ?>
    <?php if($model->isNewRecord):?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'confirm_password')->passwordInput() ?>
    <?php else:?>
    <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'不填则是原密码，填则代表修改密码']) ?>
    <?= $form->field($model, 'confirm_password')->passwordInput(['placeholder'=>'不填则是原密码，填则代表修改密码']) ?>
    <?php endif;?>


    <?= $form->field($model, 'role')->dropDownList($role, ['prompt'=>'请选择', 'style'=>'width:150px;']) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

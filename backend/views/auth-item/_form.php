<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php if(isset($_GET['id'])):?>
    <?= $form->field($model, 'type')->dropDownList([1=>'角色', 2=>'权限'],['prompt'=>'请选择','style'=>'width:150px;padding:0','class'=>'role form-control', 'disabled'=>'disablesd'])->label('类型<span style="color: grey">（更新时不可更改类型，只能创建的时候选择）</span>')?>
    <?php else:?>
    <?= $form->field($model, 'type')->dropDownList([1=>'角色', 2=>'权限'],['prompt'=>'请选择','style'=>'width:150px;padding:0','class'=>'role form-control'])->label('类型<span style="color: grey">（更新时不可更改类型，只能创建的时候选择）</span>')?>
    <?php endif;?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>


    <?= $form->field($model, 'child')->checkboxList($permision, ['style'=>'width:150px;margin-top:15px'])->label('权限<span style="color: grey">(请先选择创建类型，当创建的是一个权限时不可以勾选权限，只有角色可以)</span>')?>




    <div class="form-group">
        <?= Html::submitButton('save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?=Html::jsFile('@web/js/jquery.js')?>
<script>

    var sel = $('#authitemform-type');

    sel.change(function(){
        var type = sel.val();
        var input = $("input[name='AuthItemForm[child][]']");
        if(type==2){
          input.prop('disabled', true);
        }else{
            input.prop('disabled', false);
        }
    });
</script>

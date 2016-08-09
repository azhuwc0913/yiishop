<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GoodsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>



    <?= $form->field($model, 'goods_name')->textInput(['style'=>'width:180px;']) ?>

    <?= $form->field($model, 'cat_id')->dropDownList(\yii\helpers\ArrayHelper::map((new \backend\models\Category())->getTree(), 'id', 'cat_name'),['prompt'=>'请选择','style'=>'width:150px;']) ?>

    <?php // echo $form->field($model, 'is_promote') ?>

    <?php // echo $form->field($model, 'promote_price') ?>

    <?php  echo $form->field($model, 'promote_start_time')->textInput(['id'=>'st','style'=>'width:180px;']) ?>

    <?php  echo $form->field($model, 'promote_end_time')->textInput(['id'=>'se','style'=>'width:180px;']) ?>

    <?php // echo $form->field($model, 'is_delete') ?>

    <?php // echo $form->field($model, 'is_on_sale') ?>

    <?php // echo $form->field($model, 'is_hot') ?>

    <?php // echo $form->field($model, 'is_new') ?>

    <?php // echo $form->field($model, 'is_best') ?>

    <?php // echo $form->field($model, 'type_id') ?>

    <?php // echo $form->field($model, 'logo') ?>

    <?php // echo $form->field($model, 'sm_logo') ?>

    <?php // echo $form->field($model, 'addtime') ?>

    <?php // echo $form->field($model, 'goods_desc') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?= Html::jsFile('@web/js/jquery.js');?>
    <!--添加时间插件-->
<?= Html::cssFile('@web/extension/datetimepicker/jquery-ui-1.9.2.custom.min.css');?>
<?= Html::jsFile('@web/extension/datetimepicker/jquery-ui-1.9.2.custom.min.js');?>
<?= Html::jsFile('@web/extension/datetimepicker/datepicker-zh_cn.js');?>
<?=Html::cssFile('@web/extension/datetimepicker/time/jquery-ui-timepicker-addon.min.css');?>
<?= Html::jsFile('@web/extension/datetimepicker/time/jquery-ui-timepicker-addon.min.js');?>
<?= Html::jsFile('@web/extension/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js');?>
<script>
$.timepicker.setDefaults($.timepicker.regional['zh-CN']);
$("#st").datetimepicker();
$("#se").datetimepicker();
</script>

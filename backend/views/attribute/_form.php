<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Attribute */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attribute-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_id')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\Type::find()->all(), 'id', 'type_name'), ['prompt'=>'请选择商品类型', 'style'=>'width:200px;']) ?>

    <?= $form->field($model, 'attr_name')->textInput(['style'=>'width:150px'])->label('属性名') ?>

    <?= $form->field($model, 'attr_type')->radioList([0=>'唯一', 1=>'可选'])->label('属性类型<p style="color: grey">(选择"可选属性"时，可以对商品该属性设置多个值，同时还能对不同属性值指定不同的价格加价，用户购买商品时需要选定具体的属性值。选择"唯一属性"时，商品的该属性值只能设置一个值，用户只能查看该值。)</p>') ?>

    <?= $form->field($model, 'attr_value')->textInput(['style'=>'width:300px'])->label('属性值<span style="color: grey">(多个属性值之间用,号分开)</span>') ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

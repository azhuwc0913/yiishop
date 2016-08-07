<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Goods */

$this->title = 'Goods Number';
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="tabbody-div">
        <?php $form=ActiveForm::begin([
            'enableAjaxValidation' => false,
        ]);?>
        <table class="table_content" cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <?php if(!empty($data)):?>
                <?php foreach($data as $k=>$v):?>
                <th><?= Html::encode($v[0]['attr_name'])?></th>
                <?php endforeach;?>
                <?php endif;?>
                <th>库存量</th>
                <th>操作</th>
            </tr>
            <?php foreach($goods_number_data as $k=>$v):?>
                <tr>
                    <?php if(!empty($data)):?>
                        <?php foreach($data as $k1=>$v1):?>
                            <td><select name="ga[]"><option value="">请选择</option>

                                    <?php foreach($v1 as $k2=>$v2):?>
                                        <?php if(strpos(','.$v['goods_attr_id'].',', ','.$v2['id'].',')!==false){$selected="selected='selected'";}else{$selected='';}?>
                                        <option <?= Html::encode($selected)?> value="<?php echo $v2['id']?>"><?php echo $v2['value']?></option>
                                    <?php endforeach;?>
                                </select></td>
                        <?php endforeach;?>
                    <?php endif;?>
                    <td><input type="text" name="goods_number[]" value="<?= $v['number']?>"></td>
                    <td><input type="button" value="-" onclick="addNewButton(this)"></td>
                </tr>
            <?php endforeach;?>
                <tr>
                    <?php if(!empty($data)):?>
                        <?php foreach($data as $k=>$v):?>
                            <td><select name="ga[]"><option value="">请选择</option>

                                    <?php foreach($v as $k1=>$v1):?>
                                <option value="<?php echo $v1['id']?>"><?php echo $v1['value']?></option>
                                <?php endforeach;?>
                                </select></td>
                        <?php endforeach;?>
                    <?php endif;?>
                   <td><input type="text" name="goods_number[]" value="0"></td>
                    <td><input type="button" value="+" onclick="addNewButton(this)"></td>
                </tr>
            <tr><td colspan="<?php echo count($data)+2;?>" align="center"><input style="color: red" type="submit" value="提交"/> </td></tr>
            </table>


        <?php ActiveForm::end()?>
    </div></div>
<?= Html::jsFile('@web/js/jquery.js');?>
<script>
    function addNewButton(o){
        var flag = $(o).val();

        var parent_node = $(o).parent().parent();

        var new_node = parent_node.clone();
        if(flag=='+'){
        new_node.find("input[type=button]").val('-');
         parent_node.after(new_node);
        }else{
            parent_node.remove();
        }
    }
</script>
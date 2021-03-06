<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Goods */

$this->title = 'Create Goods';
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="tab-div">
        <div id="tabbar-div" >
            <p>
                <span class="tab-front" id="general-tab">通用信息</span>
                <span class="tab-back" id="description-tab">商品描述</span>
                <span class="tab-back" id="member-tab">会员信息</span>
                <span class="tab-back" id="attribute-tab">商品属性</span>
                <span class="tab-back" id="picture-tab">商品图片</span>
            </p>
        </div>
        <div id="tabbody-div">
            <?php $form=ActiveForm::begin([
                'id'=>'upload',
                'enableAjaxValidation' => false,
                'options'=>['enctype'=>'multipart/form-data']
            ]);?>
                <table width="90%" class="table_content" align="center">
                    <tr>
                        <td align="right">商品名称：</td>
                        <td><input type="text" name="Goods[goods_name]" value=""size="30" />
                            <span class="require-field">*</span></td>
                    </tr>

                    <tr>
                        <td align="right">商品分类：</td>
                        <td>
                            <select name="Goods[cat_id]">
                                <option value="0">请选择...</option>
                                <?php foreach($cateData as $v):?>
                                <option value="<?= $v['id']?>"><?= str_repeat('----',$v['level']).$v['cat_name']?></option>
                               <?php endforeach;?>
                            </select>
                            <span class="require-field">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">商品图片：</td>
                        <td>
                            <?= $form->field($model, 'logo')->fileInput(['class'=>'promote'])->label('商品图片')?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">本店售价：</td>
                        <td>
                            <input type="text" name="Goods[shop_price]" value="0" size="20"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">市场售价：</td>
                        <td>
                            <input type="text" name="Goods[market_price]" value="0" size="20"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <input type="checkbox" value="1" name="Goods[is_promote]" onclick="if($(this).prop('checked')){$('.promote').removeAttr('disabled');}else{$('.promote').attr('disabled', 'disabled')}">促销价:
                        </td>
                        <td align="left"><input class = "promote" type="text" name="Goods[promote_price]" disabled="disabled"></td>
                    </tr>
                    <tr>
                        <td align="right">促销日期:</td>
                        <td align="left">
                            <input type="text" class = "promote" name="Goods[promote_start_time]" id="st" disabled="disabled">-<input type="text" class = "promote" name="Goods[promote_end_time]" id="et" disabled="disabled">
                        </td>
                    </tr>

                    <tr>
                        <td align="right">是否上架：</td>
                        <td>
                            <input type="radio" name="Goods[is_on_sale]" value="1"/> 是
                            <input type="radio" name="Goods[is_on_sale]" value="0"/> 否
                        </td>
                    </tr>
                    <tr>
                        <td align="right">加入推荐：</td>
                        <td>
                            <input type="checkbox" name="Goods[is_best]" value="1" /> 精品
                            <input type="checkbox" name="Goods[is_new]" value="1" /> 新品
                            <input type="checkbox" name="Goods[is_hot]" value="1" /> 热销
                        </td>
                    </tr>

                </table>
                <!-- 简单描述 -->
                <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
                    <tr><td align="right">商品简单描述：</td><br />
                    <td>
                        <textarea id="goods_desc" name="Goods[goods_desc]"></textarea>
                    </td>
                    </tr>
                </table>

                <!-- 会员价格 -->
                <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
                    <tr>
                        <td colspan="2" align="center" style="color: #7a43b6;font-size: large">会员价格:</td>
                    </tr>
                    <?php foreach($member_data as $v):?>

                    <tr>
                    <td align="right"><?= Html::encode($v['level_name'])?>(<span style="color: grey">折扣率:<?= Html::encode($v['rate'])?></span>)</td><td align="left"><input type="text" name="member_price[]" value="-1"/></td>
                    </tr>
                    <?php endforeach;?>
                    <tr><td colspan="2" align="center" style="color:grey">会员价格为-1时表示会员价格按会员等级折扣率计算。你也可以为每个等级指定一个固定价格</td></td></tr>
                </table>
                <!-- 商品属性 -->
                <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none">
                    <tr>
                        <td align="right" style="color: #7a43b6;font-size: large">商品属性：</td><br />
                        <td align="left">
                        <select id="type" name="Goods[type_id]" style="width: 150px;">
                            <option value="">请选择</option>
                            <?php foreach($typeData as $v):?>
                            <option value="<?= Html::encode($v['id'])?>"><?= Html::encode($v['type_name'])?></option>
                            <?php endforeach;?>
                        </select>
                        </td>
                    </tr>
                    <tr><td>&nbsp;&nbsp;</td><td id="tbody-goodsAttr" style="padding:0;width: 70%" align="left"></td></tr>
                </table>
                <!-- 商品图片 -->
                <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
                    <tr>
                        <td colspan="2" align="center">商品图片：</td><br />
                    </tr>
                    <tr>
                        <td align="right" style="width:45%;"><a href="#" onclick="addNewImage(this)">[+]</a>图片描述</td>
                        <td align="left"><?= $form->field($goods_pic_model, 'pic[]')->fileInput(['multiple' => ''])->label('添加多张商品图片')?></td>
                    </tr>
                </table>
                <div class="button-div">
                    <input type="submit" value=" 确定 " class="button"/>
                    <input type="reset" value=" 重置 " class="button" />
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
<?= Html::jsFile('@web/js/jquery.js');?>
<!--添加时间插件-->
<?= Html::cssFile('@web/extension/datetimepicker/jquery-ui-1.9.2.custom.min.css');?>
<?= Html::jsFile('@web/extension/datetimepicker/jquery-ui-1.9.2.custom.min.js');?>
<?= Html::jsFile('@web/extension/datetimepicker/datepicker-zh_cn.js');?>
<?=Html::cssFile('@web/extension/datetimepicker/time/jquery-ui-timepicker-addon.min.css');?>
<?= Html::jsFile('@web/extension/datetimepicker/time/jquery-ui-timepicker-addon.min.js');?>
<?= Html::jsFile('@web/extension/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js');?>

<!--添加在线编辑器的插件-->
<?= Html::cssFile('@web/extension/ueditor/themes/default/css/ueditor.min.css') ?>
<?= Html::jsFile('@web/extension/ueditor/ueditor.config.js')?>
<?= Html::jsFile('@web/extension/ueditor/ueditor.all.min.js')?>
<?= Html::jsFile('@web/extension/ueditor/lang/zh-cn/zh-cn.js')?>
<script>
    $('#tabbar-div p span').click(function(){

        var i = $(this).index();

        $('.table_content').hide();

        $('.table_content').eq(i).show();

        $('.tab-front').removeClass('tab-front').addClass('tab-back');
        $(this).removeClass('tab-back').addClass('tab-front');
    });
    //添加时间插件
    $.timepicker.setDefaults($.timepicker.regional['zh-CN']);
    $("#st").datetimepicker();
    $("#et").datetimepicker();

    //编辑器
    UE.getEditor('goods_desc', {
        initialFrameWidth : "100%",
        initialFrameHeight : 350
    });

    $("#type").change(function(){
        var value = $(this).val();
        $.ajax({
            type:'GET',
          // data:{type_id:value},
            url:"<?= Url::to(['goods/ajax-get-type-attribute'])?>?type_id="+value,
            dataType:'json',
            success:function(data){
                   var html = '<table align="left">';
                    $(data.data).each(function(k, v){
                        if(v.attr_value==''){
                          html+= "<tr><td align='right'>"+ v.attr_name+"</td><td align='left'><input type='text' name='ga["+ v.id+"][]'/></td></tr>";
                        }else{
                            //先将attr_value值变为数组

                            var options = v.attr_value.split(',');
                           // console.log(options);
                                html+="<tr>";
                                if(v.attr_type==1){
                                  html+= "<td align='right'><a href='#' onclick='addNew(this)'>[+]</a>"+v.attr_name+"</td>";
                                }else{
                                    html+="<td align='right'>"+ v.attr_name+"</td>";
                                }
                                html+="<td align='left'><select name='ga["+ v.id+"][]' style='width:140px;'><option value=''>请选择</option>";

                                for(var i = 0; i<options.length;i++){
                                    html+= "<option value='"+options[i]+"'>"+options[i]+"</option>";
                                }
                                html+= "</select>";
                                if(v.attr_type==1){
                                  html+=  "属性价格<input type='text' name='gp["+ v.id+"][]'>";
                                }
                            html+="</td></tr>";
                        }
                    });
                html+="<table>";

                    $('#tbody-goodsAttr').html(html);
            }
        });
    });


    function addNew(o){
        var parent_str = $(o).parent().parent();
        var str = parent_str.clone();
        if($(o).html()=='[+]'){
            parent_str.after(str);
            str.find('a').html('[-]');
        }else{
            parent_str.remove();
        }
    }

    //克隆复制添加多张图片
    function addNewImage(o){
        var parent_str = $(o).parent().parent();
        var str = parent_str.clone();
        if($(o).html()=='[+]'){
            parent_str.after(str);
            str.find('a').html('[-]');
        }else{
            parent_str.remove();
        }
    }
</script>

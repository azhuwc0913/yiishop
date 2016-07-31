<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = 'Create Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <form action="<?php echo \yii\helpers\Url::to(['category/create'])?>" method="post" role="form">
        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        <div class="form-group">
            <label for="cat_name">分类名称</label>
            <input type="text" class="form-control" id="name"
                 name="cat_name" style="width: 150px;"  placeholder="请输入分类名称">
        </div>
        <div class="dropdown" style="height: 60px;width:100px">
        <select name="p_id">
            <option value="0">顶级分类</option>
            <?php foreach($cateData as $v):?>
                <option value="<?=$v['id']?>"><?php echo str_repeat('----', $v['level']).$v['cat_name']?></option>
            <?php endforeach;?>
        </select>

        </div>

        <div style="height: 150px">
        <button type="submit" class="btn btn-default">提交</button>
        </div>
    </form>

</div>

<?php

	use yii\helpers\Html;
	use yii\grid\GridView;

	/* @var $this yii\web\View */
	/* @var $searchModel app\models\CategorySearch */
	/* @var $dataProvider yii\data\ActiveDataProvider */

	$this->title = 'Categories';
	$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
	<table class="table table-hover">
		<tr>
			<td>id</td>
			<td>类型名</td>
			<td>操作</td>
		</tr>
		<?php foreach($cateData as $v):?>
		<tr>
			<td><?php echo $v['id']?></td>
			<td><?php echo str_repeat('----', $v['level']).$v['cat_name']?></td>
			<td>
				<a href="<?php echo \yii\helpers\Url::to(['category/update', 'id'=>$v['id']]);?>"><span class="glyphicon glyphicon-pencil" style="margin-right:5px;"></span></a>
				<a onclick="return confirm('你确定要删除吗?')" href="<?php echo \yii\helpers\Url::to(['category/delete', 'id'=>$v['id']]);?>"><span class="glyphicon glyphicon-remove" style="margin-left:5px;"></span></a>
			</td>
		</tr>
		<?php endforeach;?>

	</table>
	</div>
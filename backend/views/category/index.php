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
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'cat_name',
                'label'=>'类型名称',
                'value'=>
                    function($model){
                        $data = (new \backend\models\Category())->getTree();
                        $level = 0;

                        foreach($data as $k=>$v){
                            if($v['id']==$model->id){
                               $level = $v['level'] ;
                            }
                        }
                        return str_repeat('----', $level).$model->cat_name;//主要通过此种方式实现
                    },
                'headerOptions' => ['width' => '170'],
            ],
            'p_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

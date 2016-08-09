<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Goods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Goods', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'goods_name',
            [
                'attribute' => 'cat_id',
                'label'   =>  '所属分类',
                'value'   => 'category.cat_name'
            ],
            'shop_price',
            'market_price',
            ['class' => 'yii\grid\ActionColumn','header' => '操作',],
            [
                'label'=>'更多操作',
                'format'=>'raw',
                'value' => function($data){
                    $url = "http://admin.yii_shop.com/goods/kucun?id=".$data->id;
                    return Html::a('添加商品库存', $url);
                }
            ],

            // 'is_promote',
            // 'promote_price',
            // 'promote_start_time:datetime',
            // 'promote_end_time:datetime',
            // 'is_delete',
            // 'is_on_sale',
            // 'is_hot',
            // 'is_new',
            // 'is_best',
            // 'type_id',
            // 'logo',
            // 'sm_logo',
            // 'addtime:datetime',
            // 'goods_desc:ntext',


        ],
    ]); ?>
</div>

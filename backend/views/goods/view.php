<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Goods */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'goods_name',
            'cat_id',
            'shop_price',
            'market_price',
            'is_promote',
            'promote_price',
            'promote_start_time:datetime',
            'promote_end_time:datetime',
            'is_delete',
            'is_on_sale',
            'is_hot',
            'is_new',
            'is_best',
            'type_id',
            'logo',
            'sm_logo',
            'addtime:datetime',
            'goods_desc:ntext',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MemberLevel */

$this->title = 'Update Member Level: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Member Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="member-level-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

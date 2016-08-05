<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MemberLevel */

$this->title = 'Create Member Level';
$this->params['breadcrumbs'][] = ['label' => 'Member Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-level-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

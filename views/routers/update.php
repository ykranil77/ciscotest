<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Routers */

$this->title = 'Update Routers: ' . $model->sapid;
$this->params['breadcrumbs'][] = ['label' => 'Routers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sapid, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="routers-update col-md-6">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

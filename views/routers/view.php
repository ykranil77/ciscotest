<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Routers */

$this->title = $model->sapid;
$this->params['breadcrumbs'][] = ['label' => 'Routers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="routers-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'type',
            'sapid',
            'hostname',
            'loopback',
            'mac_address',
            'status',
            'created',
        ],
    ]) ?>

</div>

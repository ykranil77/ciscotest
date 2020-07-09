<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Routers */

$this->title = 'Create Routers';
$this->params['breadcrumbs'][] = ['label' => 'Routers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="routers-create col-md-6">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

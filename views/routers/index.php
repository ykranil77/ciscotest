<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\RoutersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Routers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="routers-index">
    <p>
        <?= Html::a('Create Routers', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'type',
            'sapid',
            'hostname',
            'loopback',
            'mac_address',
            [
                'header' => 'Status',
                'attribute' => 'status',
                'contentOptions' => ['style' => 'width:80px; text-align:center; white-space: normal;'],
                'filter' => [1 => 'Active', 0 => 'Soft Deleted'],
                'value' => function($model) {                                
                    return $model->status == 1 ? 'Active' : 'Soft Deleted';
                }
            ],
            //'created',

            [
                'header' => 'Actions',
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width:80px; text-align:center; white-space: normal;'],
                'template' => '{update} {delete}',
                'visibleButtons' => [
                    'update' => function ($model, $key, $index) {
                        return $model->status !== 0;
                     },
                 ],
                 'buttons' => [
                    'delete' => function($url, $model) {
                        if($model->status != 0) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-trash"></span>',
                                Url::toRoute(['routers/soft-delete', 'id' => $model->id]),
                                [
                                    'title' => 'Delete',
                                    'class' => 'btn btn-link text-danger p-0 mr-2',
                                    'data-pjax' => '0',
                                    'data' => [
                                        'confirm' => Yii::t('app', 'Are you sure you want to delete this router?')
                                    ],
                                ]
                            );
                        }
                    }
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php
/** @var yii\web\View $this */

use app\models\Request;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<h1>admin/index</h1>

<p>
    <?= Html::a('Create Vehicle', ['vehicle/create'], ['class' => 'btn btn-success']) ?>
</p>
<div class="w-25 h-25">
    <img src="/images/1. Черный кот с рыбкой.jpg" alt="sdasd" class="base-image">
</div>

<p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'author.username',
            'vehicle.model',
            [
                'label' => 'Статус',
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($data) {
                    if ($data->status == 0) return 'Новая' . ' ' . Html::a('Решить', "/request/approve?id=$data->id") .
                        ' ' . Html::a('Отменить', "/request/cancel?id=$data->id");
                    if ($data->status == 1) return 'Решена';
                    if ($data->status == 2) return 'Отменена';
                },
                'filter' => ['0' => 'Новая', '1' => 'Решена', '2' => 'Отменена'],
                'filterInputOptions' => ['prompt' => 'Все статусы', 'class' => 'form-control', 'id' => null]
            ],
            'date',
            [
                'label' => '',
                'format' => 'html',
                'value' => function ($data) {
                    return Html::a('Редактировать', "/request/update?id=$data->id") .
                        ' ' . Html::a('Просмотреть', "/request/view?id=$data->id");
                },
                'filter' => ['0' => 'Новая', '1' => 'Решена', '2' => 'Отменена'],
                'filterInputOptions' => ['prompt' => 'Все статусы', 'class' => 'form-control', 'id' => null]
            ],
        ],
    ]);
    ?>
</p>

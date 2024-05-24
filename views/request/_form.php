<?php

use app\models\Vehicle;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\BootstrapAsset;

/** @var yii\web\View $this */
/** @var app\models\Request $model */
/** @var yii\widgets\ActiveForm $form */

// Register Bootstrap 4 assets
BootstrapAsset::register($this);
?>

<div class="request-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $items = Vehicle::find()
        ->select(['model'])
        ->indexBy('id')
        ->column();
    ?>

    <?= $form->field($model, 'vehicle_id')->dropDownList($items) ?>

    <?= $form->field($model, 'date')->dropDownList(
            [
                    '2024-05-21' => '2024-05-21',
                    '2024-05-22' => '2024-05-22',
                    '2024-05-23' => '2024-05-23',
                    '2024-05-24' => '2024-05-24',
            ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

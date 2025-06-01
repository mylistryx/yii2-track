<?php

use app\models\Track;
use yii\bootstrap5\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Track $model
 */

$form = ActiveForm::begin();
?>
    <div class="row">
        <div class="col-8">
            <?= $form->field($model, 'track_number')->textInput(['autofocus' => true, 'required' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'status')->dropDownList(Track::getStatusList()) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <?= Html::submitButton($model->isNewRecord ? 'Create new track' : 'Update track', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php
ActiveForm::end();
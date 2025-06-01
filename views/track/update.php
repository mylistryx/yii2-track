<?php

use app\models\Track;
use yii\web\View;

/**
 * @var View $this
 * @var Track $model
 */

$this->title = 'Update track #' . $model->id;

$this->params['breadcrumbs'][] = ['label' => 'Tracks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', ['model' => $model]);
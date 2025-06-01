<?php

use app\models\Track;
use yii\web\View;

/**
 * @var View $this
 * @var Track $model
 */

$this->title = 'Create track';

$this->params['breadcrumbs'][] = ['label' => 'Tracks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', ['model' => $model]);
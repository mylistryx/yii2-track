<?php

use app\models\Track;
use yii\web\View;
use yii\widgets\DetailView;

/**
 * @var View $this
 * @var Track $model
 */

$this->title = 'View track #' . $model->id;

$this->params['breadcrumbs'][] = ['label' => 'Tracks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'track_number',
        [
            'attribute' => 'status',
            'value' => fn($model) => $model->getStatusLabel()
        ],
        'created_at:datetime',
        'updated_at:datetime',
    ]
]);
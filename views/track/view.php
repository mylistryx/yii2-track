<?php

use app\models\Track;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\DetailView;

/**
 * @var View $this
 * @var Track $model
 */

$this->title = 'View track #' . $model->id;

$this->params['breadcrumbs'][] = ['label' => 'Tracks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
        <div class="col-4">
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary mb-4']) ?>
        </div>
    </div>
<?= DetailView::widget([
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
]); ?>

<?php
if ($model->getTrackChangelogs()->count()) {
    $changelogDataProvider = new ArrayDataProvider([
        'models' => $model->getTrackChangelogs()->orderBy(['id' => SORT_DESC])->all(),
    ]);

    echo "<h5>Changelog</h5>";

    echo GridView::widget([
        'dataProvider' => $changelogDataProvider,
        'columns' => [
            [
                'label' => 'Changed at',
                'attribute' => 'created_at',
                'format' => 'datetime',
            ],
            [
                'attribute' => 'changes',
                'format' => 'html',
                'label' => 'Previous values',
                'value' => fn($model) => nl2br((string)$model)
            ],
        ]
    ]);
}
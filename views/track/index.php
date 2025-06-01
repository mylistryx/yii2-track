<?php

use app\models\Track;
use app\models\TrackSearch;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\web\View;

/**
 * @var View $this
 * @var TrackSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = 'View track list';
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="row mb-4">
        <div class="col-4">
            <?= Html::a('Create track', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

<?= GridView::widget([
    'filterModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => SerialColumn::class],
        'id',
        'track_number',
        [
            'attribute' => 'status',
            'value' => fn(Track $model) => ($model->getStatusLabel()),
            'filter' => Track::getStatusList(),
        ],
        'created_at:datetime',
        'updated_at:datetime',
        ['class' => ActionColumn::class],
    ]
]);
<?php

namespace app\controllers\api;

use app\models\Track;
use yii\base\DynamicModel;
use yii\data\ActiveDataFilter;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

final class TrackController extends ActiveController
{
    public $modelClass = Track::class;

    public function actions(): array
    {
        $actions = parent::actions();

        $actions['index']['dataFilter'] = [
            'class' => ActiveDataFilter::class,
            'searchModel' => new DynamicModel(['status'])->addRule(
                ['status'],
                'in',
                ['range' => array_keys(Track::getStatusList())]
            ),
        ];

        return $actions;
    }

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class,
                QueryParamAuth::class,
            ],
        ];

        return $behaviors;
    }
}
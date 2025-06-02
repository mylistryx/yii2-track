<?php

namespace app\controllers\api;

use app\models\Track;
use InvalidArgumentException;
use Throwable;
use Yii;
use yii\base\DynamicModel;
use yii\data\ActiveDataFilter;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;

final class TrackController extends ActiveController
{
    public $modelClass = Track::class;

    public function verbs(): array
    {
        $verbs = parent::verbs();
        $verbs['update-multiple'] = ['PUT', 'PATCH'];
        return $verbs;
    }

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
            'except' => ['index', 'view', 'options'],
        ];

        return $behaviors;
    }

    public function actionUpdateMultiple()
    {
        $params = Yii::$app->getRequest()->getBodyParams();

        $status = $params['status'] ?? null;
        $idList = $params['id'] ?? null;

        $model = new DynamicModel(['status' => $status, 'id' => $idList])
            ->addRule(['status', 'id'], 'required')
            ->addRule(['status'],
                'in',
                ['range' => array_keys(Track::getStatusList())])
            ->addRule(['id'],
                'each',
                ['rule' => ['integer']],
            )
            ->addRule(['id'],
                'each',
                ['rule' => ['exist', 'targetClass' => Track::class, 'targetAttribute' => 'id']],
            );


        if (!$model->validate()) {
            throw new ServerErrorHttpException(implode(',', $model->getFirstErrors()));
        }

        /** Транзакция - чтоб пачкой. Если сделать BatchUpdate - Event на Update не отработает, т.к. DBA */
        $transaction = Yii::$app->db->beginTransaction();
        $response = [];
        $idList = array_unique($idList);

        foreach ($idList as $id) {
            $model = Track::findOne($id);
            $model->status = $status;
            $model->save();
            $response[$model->id] = $model;
        }

        $transaction->commit();

        return $response;
    }
}
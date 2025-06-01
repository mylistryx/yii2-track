<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * @property int $id
 * @property string $track_number
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Track extends ActiveRecord
{
    public const string STATUS_NEW = 'new';
    public const string STATUS_IN_PROGRESS = 'in_progress';
    public const string STATUS_COMPLETED = 'completed';
    public const string STATUS_FAILED = 'failed';
    public const string STATUS_CANCELED = 'canceled';

    public static function tableName(): string
    {
        return 'track';
    }

    public function rules(): array
    {
        return [
            [['status', 'track_number'], 'required'],
            ['status', 'in', 'range' => array_keys(self::getStatusList())],
            ['track_number', 'string', 'max' => 255],
            ['track_number', 'unique'],
        ];
    }

    public function behaviors(): array
    {
        return [
            'TimeStamp' => [
                'class' => TimestampBehavior::class,
                'value' => date('Y-m-d H:i:s'),
            ]
        ];
    }

    public static function getStatusList(): array
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_FAILED => 'Failed',
            self::STATUS_CANCELED => 'Canceled',
        ];
    }

    public function getStatusLabel(): string
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status);
    }
}
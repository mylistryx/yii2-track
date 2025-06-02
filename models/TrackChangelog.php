<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 * @property int $id
 * @property int $track_id
 * @property mixed $changes
 * @property string $created_at
 *
 * @property-read Track $track
 */
class TrackChangelog extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'track_changelog';
    }

    public function behaviors(): array
    {
        return [
            'TimeStamp' => [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    public function getTrack(): ActiveQuery
    {
        return $this->hasOne(Track::class, ['id' => 'track_id']);
    }

    public function __toString(): string
    {
        $response = [];
        foreach ($this->changes as $key => $value) {
            $response[] = "$key :: $value";
        }
        return implode(PHP_EOL, $response);
    }
}
<?php

use app\models\Track;
use Faker\Factory;
use yii\db\Migration;

class m250601_225055_seed_tracks_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $values = [];
        $faker = Factory::create();
        for ($i = 1; $i < 1000; $i++) {
            $values[$i] = [
                $i,
                $faker->uuid,
                array_rand(Track::getStatusList()),
                $faker->date('Y-m-d H:i:s'),
                $faker->date('Y-m-d H:i:s'),
            ];
        }

        $this->batchInsert(Track::tableName(), [
            'id',
            'track_number',
            'status',
            'created_at',
            'updated_at'
        ], $values);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->truncateTable(Track::tableName());
    }
}

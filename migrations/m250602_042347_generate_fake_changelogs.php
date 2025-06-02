<?php

use app\models\Track;
use app\models\TrackChangelog;
use Faker\Factory;
use yii\db\Migration;

class m250602_042347_generate_fake_changelogs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $model = Track::findOne(['id' => 1]);
        $faker = Factory::create();
        for ($i = 1; $i < 10; $i++) {
            $model->track_number = $faker->uuid;
            $model->status = array_rand(Track::getStatusList());
            $model->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->truncateTable(TrackChangelog::tableName());
    }
}

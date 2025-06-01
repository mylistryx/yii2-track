<?php

use yii\db\Migration;

class m250601_203505_track extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('track', [
            'id' => $this->primaryKey(),
            'track_number' => $this->string(50)->notNull()->unique(),
            'status' => $this->string(50)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('track');
    }
}

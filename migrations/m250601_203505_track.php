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

        $this->createIndex('idx-track-status', 'track', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropIndex('idx-track-status', 'track');
        $this->dropTable('track');
    }
}

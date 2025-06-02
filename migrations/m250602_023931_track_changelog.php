<?php

use yii\db\Migration;

class m250602_023931_track_changelog extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function safeUp(): void
    {
        $this->createTable('track_changelog', [
            'id' => $this->primaryKey(),
            'track_id' => $this->integer()->notNull(),
            'changes' => $this->json()->null(),
            'created_at' => $this->dateTime()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-track-changelog-track_id',
            'track_changelog',
            'track_id',
            'track',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey('fk-track-changelog-track_id', 'track_changelog');
        $this->dropTable('track_changelog');
    }
}

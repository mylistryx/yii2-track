<?php

namespace app\components;

use app\models\Track;
use app\models\TrackChangelog;
use yii\base\BootstrapInterface;
use yii\base\Event;

class TrackLogger implements BootstrapInterface
{
    public ?array $skipAttributes = ['id', 'created_at', 'updated_at'];

    public function bootstrap($app): void
    {
        Event::on(
            Track::class,
            Track::EVENT_AFTER_UPDATE,
            [$this, 'trackUpdated']
        );
    }

    public function trackUpdated(Event $event): void
    {
        $arrayToDiff = array_combine($this->skipAttributes, array_fill(0, count($this->skipAttributes), null));

        $changes = array_diff_key($event->changedAttributes, $arrayToDiff);
        if ($changes) {
            $changeLog = new TrackChangelog([
                'track_id' => $event->sender->id,
                'changes' => $changes
            ]);

            $changeLog->save();
        }
    }
}
<?php

namespace App\Transformers;

use App\Models\Event;
use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Event  $event
     * @return array
     */
    public function transform(Event $event): array
    {
        return [
            'id' => (int) $event->id,
            'title' => (string) $event->title,
            'start_date_time' => (string) $event->start_date_time,
            'end_date_time' => (string) $event->end_date_time,
            'province_id' => (int) $event->province_id,
            'city_id' => (int) $event->city_id,
            'address' => (string) $event->address,
            'latitude' => (string) $event->latitude,
            'longitude' => (string) $event->longitude,
            'photo' => (string) $event->photo,
        ];
    }
}

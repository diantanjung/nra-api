<?php

namespace App\Transformers;

use App\Models\Notification;
use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Notification  $notif
     * @return array
     */
    public function transform(Notification $notif): array
    {
        return [
            'id' => (int) $notif->id,
            'notifiable_type' => (string) $notif->notifiable_type,
            'notifiable_id' => (int) $notif->notifiable_id,
            'user_id' => (int) $notif->user_id,
            'user_name' => (string) ($notif->user->name ?? ""),
            'type' => (string) $notif->type,
            'is_read' => (bool) $notif->is_read,
            'status' => (string) $notif->status,
            'description' => (string) $notif->description,
            'created_at' => (string) $notif->created_at,
            'updated_at' => (string) $notif->updated_at,
        ];
    }
}

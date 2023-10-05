<?php

namespace App\Transformers;

use App\Models\Announcement;
use League\Fractal\TransformerAbstract;

class AnnouncementTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return array
     */
    public function transform(Announcement $announcement): array
    {
        return [
            'id' => (int) $announcement->id,
            'client_id' => (int) $announcement->client_id,
            'title' => (string) $announcement->title,
            'content' => (string) $announcement->content,
            'attachment' => (string) $announcement->attachment,
            'is_active' => (bool) $announcement->is_active,
            'created_at' => (string) $announcement->created_at,
        ];
    }
}

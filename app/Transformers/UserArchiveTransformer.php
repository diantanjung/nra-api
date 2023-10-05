<?php

namespace App\Transformers;

use App\Models\UserArchive;
use League\Fractal\TransformerAbstract;

class UserArchiveTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\UserArchive  $user_archive
     * @return array
     */
    public function transform(UserArchive $user_archive): array
    {
        return [
            'id' => (int) $user_archive->id,
            'user_id' => (int) $user_archive->user_id,
            'archive_id' => (int) $user_archive->archive_id,
            'archive_label' => (string) $user_archive->master->name,
            'attachment' => (string) $user_archive->attachment,
        ];
    }
}

<?php

namespace App\Transformers;

use App\Models\Archive;
use League\Fractal\TransformerAbstract;

class ArchiveTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Archive  $archive
     * @return array
     */
    public function transform(Archive $archive): array
    {
        return [
            'id' => (int) $archive->id,
            'name' => (string) $archive->name,
        ];
    }
}

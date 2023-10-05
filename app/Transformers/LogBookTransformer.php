<?php

namespace App\Transformers;

use App\Models\LogBook;
use League\Fractal\TransformerAbstract;

class LogBookTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\LogBook  $log_book
     * @return array
     */
    public function transform(LogBook $log_book): array
    {
        return [
            'id' => (int) $log_book->id,
            'user_id' => (int) $log_book->user_id,
            'user_name' => (string) $log_book->user->name,
            'category' => (string) $log_book->category,
            'datetime' => (string) $log_book->datetime,
            'activity' => (string) $log_book->activity,
            'attachment' => (string) $log_book->attachment,
        ];
    }
}

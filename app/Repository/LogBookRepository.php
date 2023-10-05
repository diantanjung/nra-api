<?php

namespace App\Repository;

use App\Models\LogBook;
use App\Transformers\LogBookTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LogBookRepository
{
    /**
     * Get list of paginated log books.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $log_books = LogBook::filter($request)->orderBy('datetime')->paginate($request->get('per_page', 20));

        return fractal($log_books, new LogBookTransformer())->toArray();
    }

    /**
     * Get a log book by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $log_book = LogBook::findOrFail($id);

        return fractal($log_book, new LogBookTransformer())->toArray();
    }

    public function getDaily(int $user_id)
    {
        $user_log = LogBook::where('user_id', $user_id)
            ->whereDate('datetime', date('Y-m-d'))
            ->first();

        return $user_log;
    }

    /**
     * Store a new log_book.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        if (!array_key_exists('user_id', $attrs)) {
            $user = app('auth')->user();
            $attrs['user_id'] = $user->id;
        }

        $log_book = new LogBook($attrs);
        if (!$log_book->isValidFor('CREATE')) {
            throw new ValidationException($log_book->validator());
        }

        $log_book->save();

        return fractal($log_book, new LogBookTransformer())->toArray();
    }

    /**
     * Update a log book by ID.
     *
     * @param  int  $id
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateById(int $id, array $attrs): array
    {
        $log_book = LogBook::findOrFail($id);
        $log_book->fill($attrs);

        if (!$log_book->isValidFor('UPDATE')) {
            throw new ValidationException($log_book->validator());
        }

        $log_book->save();

        return fractal($log_book, new LogBookTransformer())->toArray();
    }

    /**
     * Delete a log book by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $log_book = LogBook::findOrFail($id);

        return (bool) $log_book->delete();
    }
}

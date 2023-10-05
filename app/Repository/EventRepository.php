<?php

namespace App\Repository;

use App\Models\Event;
use App\Transformers\EventTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class EventRepository
{
    /**
     * Get list of paginated events.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $events = Event::filter($request)->paginate($request->get('per_page', 20));

        return fractal($events, new EventTransformer())->toArray();
    }

    /**
     * Get a event by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $event = Event::findOrFail($id);

        return fractal($event, new EventTransformer())->toArray();
    }

    /**
     * Store a new event.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $event = new Event($attrs);
        if (!$event->isValidFor('CREATE')) {
            throw new ValidationException($event->validator());
        }

        $event->save();

        return fractal($event, new EventTransformer())->toArray();
    }

    /**
     * Update a event by ID.
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
        $event = Event::findOrFail($id);
        $event->fill($attrs);
        if (!$event->isValidFor('UPDATE')) {
            throw new ValidationException($event->validator());
        }

        $event->save();

        return fractal($event, new EventTransformer())->toArray();
    }

    /**
     * Delete a event by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $event = Event::findOrFail($id);

        return (bool) $event->delete();
    }
}

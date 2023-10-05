<?php

namespace App\Repository;

use App\Models\Notification;
use App\Transformers\NotificationTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NotificationRepository
{
    /**
     * Get list of paginated notifications.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $notifications = Notification::filter($request)
            ->orderBy('created_at', 'DESC')
            ->orderBy('is_read', 'ASC')
            ->get();

        return fractal($notifications, new NotificationTransformer())->toArray();
    }

    public function checkReadStatus(): array
    {
        $user_auth = app('auth')->user();
        $notification = Notification::where('is_read', 0)
            ->where('user_id', $user_auth->id)
            ->first(['is_read']);

        return [
            'user_id' => $user_auth->id,
            'read_status' => ($notification->is_read ?? 1) == 0 ? false : true,
        ];
    }

    /**
     * Store a new notification.
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

        $notification = new Notification($attrs);
        if (!$notification->isValidFor('CREATE')) {
            throw new ValidationException($notification->validator());
        }

        $notification->save();

        return fractal($notification, new NotificationTransformer())->toArray();
    }

    /**
     * Update a notification by ID.
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
        $notification = Notification::findOrFail($id);
        $notification->fill($attrs);

        if (!$notification->isValidFor('UPDATE')) {
            throw new ValidationException($notification->validator());
        }

        $notification->save();

        return fractal($notification, new NotificationTransformer())->toArray();
    }

    /**
     * Delete a notification by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $notification = Notification::findOrFail($id);

        return (bool) $notification->delete();
    }

    public function deleteByAssociateId(string $type, int $id): bool
    {
        return (bool) Notification::where('notifiable_type', 'App\Models\\' . $type)
            ->where('notifiable_id', $id)
            ->delete();
    }
}

<?php

namespace App\Repository;

use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Models\User;
use App\Models\UserProfile;
use App\Transformers\UserProfileTransformer;
use App\Transformers\Web\UserProfileTransformer as WebUserProfileTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AccountRepository
{
    /**
     * Get list of paginated users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getUsers(Request $request): array
    {
        $users = User::filter($request)->paginate($request->get('per_page', 20));

        return fractal($users, new UserTransformer())->toArray();
    }

    /**
     * Get a user by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getUserById(int $id, $isWeb = false): array
    {
        $user = User::findOrFail($id);
        return $isWeb ? fractal($user, new WebUserProfileTransformer())->toArray()
            : fractal($user->profile, new UserProfileTransformer())->toArray();
    }

    public function getUserActivity(): array
    {
        $user = app('auth')->user();
        $user_id = request()->user_id ?? $user->id;

        // get attendance
        $attendanceRepo = new AttendanceRepository();
        $user_attendance_work = $attendanceRepo->getDaily($user_id, 'K');
        $user_attendance_overwork = $attendanceRepo->getDaily($user_id, 'L');

        // get log book
        $logBookRepo = new LogBookRepository();
        $user_log_book = $logBookRepo->getDaily($user_id);

        $response = [
            'work_id' => $user_attendance_work->id ?? null,
            'work_in' => ($user_attendance_work->in_log_start ?? "") != "",
            'work_out' => ($user_attendance_work->out_log_start ?? "") != "",
            'overwork_id' => $user_attendance_overwork->id ?? null,
            'overwork_in' => ($user_attendance_overwork->in_log_start ?? "") != "",
            'overwork_out' => ($user_attendance_overwork->out_log_start ?? "") != "",
            'log_book' => $user_log_book != null,
        ];

        return $response;
    }

    /**
     * Store a new user.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeUser(array $attrs): array
    {
        $user = new User($attrs);

        if (!$user->isValidFor('CREATE')) {
            throw new ValidationException($user->validator());
        }

        $user->save();
        event(new UserCreated($user));

        UserProfile::create([
            'user_id' => $user->id,
            'client_area_id' => $attrs["client_area_id"] == "" ? null : $attrs["client_area_id"],
            'department_id' => $attrs["department_id"] == "" ? null : $attrs["department_id"],
            'phone_number' => $attrs['phone_number']
        ]);

        return fractal($user, new UserTransformer())->toArray();
    }

    /**
     * Update a user by ID.
     *
     * @param  int  $id
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateUserById(int $id, array $attrs): array
    {
        $user = User::findOrFail($id);
        $user->fill($attrs);

        if (!$user->isValidFor('UPDATE')) {
            throw new ValidationException($user->validator());
        }

        $changes = $user->getDirty();
        $user->save();

        event(new UserUpdated($user, $changes));

        $user->profile->update([
            'client_area_id' => $attrs["client_area_id"],
            'department_id' => $attrs["department_id"],
            'phone_number' => $attrs['phone_number']
        ]);

        return fractal($user, new UserTransformer())->toArray();
    }

    /**
     * Delete a user by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteUserById(int $id): bool
    {
        $user = User::findOrFail($id);

        return (bool) $user->delete();
    }

    /**
     * Update a user profile by ID.
     *
     * @param  int  $id
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateUserProfile(array $attrs): array
    {
        $user = app('auth')->user();
        if (array_key_exists('user_id', $attrs)) {
            $user = User::findOrFail($attrs['user_id']);
        }

        $user_profile = $user->profile;
        if ($user_profile == null) {
            abort(400, 'Profile Not Found!');
        }

        $user->update([
            'name' => $attrs['name'],
            'username' => $attrs['username'],
        ]);

        $user_profile->update($attrs);

        return fractal($user_profile, new UserProfileTransformer())->toArray();
    }

    public function updatePhotoUser(array $attrs): array
    {
        $user = app('auth')->user();

        if (($attrs['photo'] ?? null) == null) {
            $upload = null;
        } else {
            $upload = $user->saveFiles($attrs['photo']);
        }

        $user['photo'] = $upload;
        $user->save();

        return fractal($user, new UserTransformer())->toArray();
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Models\UserProfile;
use App\Repository\AccountRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\AccountRepository  $accounts
     */
    public function __construct(AccountRepository $accounts)
    {
        $this->accounts = $accounts;
    }

    /**
     * Get all the users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $users = $this->accounts->getUsers($request);

        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * Store a user.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $user = $this->accounts->storeUser($request->all());

        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Get a user.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->accounts->getUserById($id, true);

        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Update a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $user = $this->accounts->updateUserById($id, $request->all());

        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Delete a user.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->accounts->deleteUserById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Update a user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request): JsonResponse
    {
        $user_profile = $this->accounts->updateUserProfile($request->all());

        return response()->json($user_profile, Response::HTTP_OK);
    }

    public function photo(Request $request): JsonResponse
    {
        $user_photo = $this->accounts->updatePhotoUser($request->all());

        return response()->json($user_photo, Response::HTTP_OK);
    }
}

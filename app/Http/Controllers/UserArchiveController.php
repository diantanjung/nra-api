<?php

namespace App\Http\Controllers;

use App\Repository\UserArchiveRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserArchiveController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\UserArchiveRepository  $user_archive
     */
    public function __construct(UserArchiveRepository $user_archive)
    {
        $this->user_archive = $user_archive;
    }

    /**
     * Get all the user archives.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $user_archives = $this->user_archive->getAll($request);

        return response()->json($user_archives, Response::HTTP_OK);
    }

    /**
     * Store a user archive.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $user_archive = $this->user_archive->store($request->all());

        return response()->json($user_archive, Response::HTTP_CREATED);
    }

    /**
     * Get a user archive.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user_archive = $this->user_archive->getById($id);

        return response()->json($user_archive, Response::HTTP_OK);
    }

    /**
     * Update a user archive.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $user_archive = $this->user_archive->updateById($id, $request->all());

        return response()->json($user_archive, Response::HTTP_OK);
    }

    /**
     * Delete a user archive.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->user_archive->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

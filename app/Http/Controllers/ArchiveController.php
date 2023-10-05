<?php

namespace App\Http\Controllers;

use App\Repository\ArchiveRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArchiveController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\ArchiveRepository  $archive
     */
    public function __construct(ArchiveRepository $archive)
    {
        $this->archive = $archive;
    }

    /**
     * Get all the archives.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $archives = $this->archive->getAll($request);

        return response()->json($archives, Response::HTTP_OK);
    }

    /**
     * Store a archive.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $archive = $this->archive->store($request->all());

        return response()->json($archive, Response::HTTP_CREATED);
    }

    /**
     * Get a archive.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $archive = $this->archive->getById($id);

        return response()->json($archive, Response::HTTP_OK);
    }

    /**
     * Update a archive.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $archive = $this->archive->updateById($id, $request->all());

        return response()->json($archive, Response::HTTP_OK);
    }

    /**
     * Delete a archive.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->archive->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

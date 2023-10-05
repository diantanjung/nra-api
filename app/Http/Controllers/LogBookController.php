<?php

namespace App\Http\Controllers;

use App\Repository\LogBookRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogBookController extends Controller
{
    protected $log_book;

    /**
     * Controller constructor.
     *
     * @param  \App\Repository\LogBookRepository  $log_book
     */
    public function __construct(LogBookRepository $log_book)
    {
        $this->log_book = $log_book;
    }

    /**
     * Get all the log books.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $log_books = $this->log_book->getAll($request);

        return response()->json($log_books, Response::HTTP_OK);
    }

    /**
     * Store a log book.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $log_book = $this->log_book->store($request->all());

        return response()->json($log_book, Response::HTTP_CREATED);
    }

    /**
     * Get a log book.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $log_book = $this->log_book->getById($id);

        return response()->json($log_book, Response::HTTP_OK);
    }

    /**
     * Update a log book.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $log_book = $this->log_book->updateById($id, $request->all());

        return response()->json($log_book, Response::HTTP_OK);
    }

    /**
     * Delete a log book.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->log_book->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

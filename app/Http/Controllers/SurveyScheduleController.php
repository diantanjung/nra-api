<?php

namespace App\Http\Controllers;

use App\Repository\SurveyScheduleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SurveyScheduleController extends Controller
{
    protected $survey_schedule;

    /**
     * Controller constructor.
     *
     * @param  \App\Repository\SurveyScheduleRepository  $survey_schedule
     */
    public function __construct(SurveyScheduleRepository $survey_schedule)
    {
        $this->survey_schedule = $survey_schedule;
    }

    /**
     * Get all the survey$survey_schedules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $survey_schedules = $this->survey_schedule->getAll($request);

        return response()->json($survey_schedules, Response::HTTP_OK);
    }

    /**
     * Store a survey_schedule.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return $this->survey_schedule->store($request->all());
    }

    /**
     * Get a survey_schedule.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): array
    {
        return $this->survey_schedule->getById($id);
    }

    /**
     * Update a survey_schedule.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $survey_schedule = $this->survey_schedule->updateById($id, $request->all());

        return response()->json($survey_schedule, Response::HTTP_OK);
    }

    /**
     * Delete a survey_schedule.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->survey_schedule->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

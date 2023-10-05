<?php

namespace App\Http\Controllers;

use App\Repository\ScheduleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScheduleController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\ScheduleRepository  $schedule
     */
    public function __construct(ScheduleRepository $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Get all the users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        // $schedules = $this->schedule->index($request);
        // return response()->json($schedules, Response::HTTP_OK);
        return responseSuccess([
          "schedule" => [
            "id" => 1,
            "type" => "shift",
            "working_hour" => "08:00 - 17:00",
            "is_holiday" => false
          ],
          "rules" => [
            [
              "id" => 1,
              "desc" => "sakit_max_2",
              "label" => "Sakit Maksimal 2 Hari"
            ],
            [
              "id" => 1,
              "desc" => "lembur > 2 jam",
              "label" => "Lembur di Atas 2 Jam"
            ],
          ]
        ]);
    }

    /**
     * Get a schedule.
     *
     * @param  int  $day
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $day): JsonResponse
    {
        // $schedule = $this->schedule->show($day);
        // return response()->json($schedule, Response::HTTP_OK);
        return responseSuccess([
          "schedule" => [
            "id" => 1,
            "type" => "shift",
            "working_hour" => "08:00 - 17:00",
            "is_holiday" => false
          ],
          "rules" => [
            [
              "id" => 1,
              "desc" => "sakit_max_2",
              "label" => "Sakit Maksimal 2 Hari"
            ],
            [
              "id" => 1,
              "desc" => "lembur > 2 jam",
              "label" => "Lembur di Atas 2 Jam"
            ],
          ]
        ]);
    }
}

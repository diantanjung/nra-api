<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Repository\AttendanceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exports\AttendanceExport;
use App\Models\Attendance;
use Maatwebsite\Excel\Facades\Excel;


class AttendanceController extends Controller
{
    protected $attendance;

    /**
     * Controller constructor.
     *
     * @param  \App\Repository\AttendanceRepository  $attendance
     */
    public function __construct(AttendanceRepository $attendance)
    {
        $this->attendance = $attendance;
    }

    /**
     * Get all the attendances.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function approvals(Request $request): JsonResponse
    {
        $approvals = $this->attendance->getApprovals($request);

        return responseSuccess($approvals);
    }

    public function index(Request $request): JsonResponse
    {
        $attendances = $this->attendance->getAll($request);

        return response()->json($attendances, Response::HTTP_OK);
    }

    /**
     * Store a attendance.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $attendance = $this->attendance->store($request->all());

        return response()->json($attendance, Response::HTTP_CREATED);
    }

    /**
     * Get a attendance.
     *
     * @param  string  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $attendance = $this->attendance->getById($id);

        return response()->json($attendance, Response::HTTP_OK);
    }

    public function coordinat(): JsonResponse
    {
        $coordinat = $this->attendance->getClientCoordinat();

        return responseSuccess($coordinat);
    }

    /**
     * Update a attendance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $attendance = $this->attendance->updateById($id, $request->all());

        return response()->json($attendance, Response::HTTP_OK);
    }

    public function updateLate(Request $request): JsonResponse
    {
        $attendance = $this->attendance->updateLateById($request->all());

        return response()->json($attendance, Response::HTTP_OK);
    }

    public function updateApproval(Request $request): JsonResponse
    {
        $attendance = $this->attendance->updateApprovalById($request->all());

        return response()->json($attendance, Response::HTTP_OK);
    }

    /**
     * Delete a attendance.
     *
     * @param  string  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $this->attendance->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function summary(Request $request)
    {
        $summary = $this->attendance->getSummary($request);

        return responseSuccess($summary);
    }

    /**
     * Generate export data.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function export(Request $request)
    {
        $check = Attendance::select('id')
            ->where('client_id', $request->client_id)
            ->whereBetween('in_log_start', [$request->start_date, $request->end_date])
            ->first();

        if ($check == null) {
            abort(400, "empty data");
        }

        $timestamp = date('dmy_His');
        $file_name = "NRA_ATTENDANCE_EXPORT_" . $timestamp . ".xlsx";
        $export = new AttendanceExport($request->start_date, $request->end_date, $request->client_id);
        $store_excel = Excel::store($export, $file_name, "public");
        if ($store_excel) {
            return responseSuccess([
                "file_url" => url("storage", $file_name)
            ]);
        }

        abort(500, "attendance export failed");
    }
}

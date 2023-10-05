<?php

namespace App\Http\Controllers;

use App\Repository\SurveyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exports\SurveyExport;
use App\Models\Survey;
use Maatwebsite\Excel\Facades\Excel;

class SurveyController extends Controller
{
    protected $survey;

    /**
     * Controller constructor.
     *
     * @param  \App\Repository\SurveyRepository  $survey
     */
    public function __construct(SurveyRepository $survey)
    {
        $this->survey = $survey;
    }

    /**
     * Get all the surveys.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $surveys = $this->survey->getAll($request);

        return response()->json($surveys, Response::HTTP_OK);
    }

    /**
     * Store a survey.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $survey = $this->survey->store($request->all());

        return response()->json($survey, Response::HTTP_CREATED);
    }

    /**
     * Get a survey.
     *
     * @param  string  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $survey = $this->survey->getById($id);

        return response()->json($survey, Response::HTTP_OK);
    }

    public function detailChiller(Request $request): JsonResponse
    {
        $survey_detail_chiller = $this->survey->getDetailChiller($request);

        return response()->json($survey_detail_chiller, Response::HTTP_OK);
    }

    public function detailProducts(Request $request): JsonResponse
    {
        $survey_detail_products = $this->survey->getDetailProducts($request);

        return response()->json($survey_detail_products, Response::HTTP_OK);
    }

    /**
     * Update a survey.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $survey = $this->survey->updateById($id, $request->all());

        if ($request->has('checked_chillers')) {
            $survey = $this->survey->addChiller($id, $request->all());
        }

        if ($request->has('checked_products')) {
            $survey = $this->survey->addProducts($id, $request->all());
        }

        return response()->json($survey, Response::HTTP_OK);
    }

    /**
     * Delete a survey.
     *
     * @param  string  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $this->survey->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Generate reports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reports(Request $request): JsonResponse
    {
        $reports = $this->survey->getReports($request);

        return responseSuccess($reports);
    }

    /**
     * Generate export data.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function export(Request $request)
    {
        $check = Survey::select('id')
            ->whereBetween('log_start', [$request->start_date, $request->end_date])
            ->first();

        if ($check == null) {
            abort(400, "empty data");
        }

        $timestamp = date('dmy_His');
        $file_name = "NRA_SURVEY_EXPORT_" . $timestamp . ".xlsx";
        $export = new SurveyExport($request->start_date, $request->end_date);
        $store_excel = Excel::store($export, $file_name, "public");
        if ($store_excel) {
            return responseSuccess([
                "file_url" => url("storage", $file_name)
            ]);
        }

        abort(500, "survey export failed");
    }

    /**
     * Update closed status.
     *
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function closed(string $id): JsonResponse
    {
        $survey = $this->survey->closedById($id);

        return response()->json($survey, Response::HTTP_OK);
    }

    /**
     * Get chiller maintenance status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function maintenance(Request $request): JsonResponse
    {
        if (!$request->has('chiller_id')) {
            abort(400, "chiller_id is required");
        }

        $status = $this->survey->chillerMaintenance($request->chiller_id);
        return responseSuccess($status);
    }
}

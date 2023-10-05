<?php

namespace App\Repository;

use App\Models\Merchant;
use App\Models\SurveySchedule;
use App\Transformers\SurveyScheduleTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SurveyScheduleRepository
{
    /**
     * Get list of paginated survey_schedules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $survey_schedules = SurveySchedule::filter($request)->paginate($request->get('per_page', 20));

        return fractal($survey_schedules, new SurveyScheduleTransformer())->toArray();
    }

    /**
     * Get a survey_schedule by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $survey_schedule = SurveySchedule::findOrFail($id);

        return fractal($survey_schedule, new SurveyScheduleTransformer())->toArray();
    }

    /**
     * Store a new survey_schedule.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): JsonResponse
    {
        $merchant = Merchant::findOrFail($attrs['merchant_id']);
        if ($merchant->is_closed) {
            $message = 'status toko ' . $merchant->name . ' sedang tutup pada ' . $merchant->is_closed_time->format('d M Y H:i');
            return responseError($message);
        }

        $survey_schedule = new SurveySchedule($attrs);
        if (!$survey_schedule->isValidFor('CREATE')) {
            throw new ValidationException($survey_schedule->validator());
        }

        $survey_schedule->save();

        return responseSuccess($survey_schedule);
    }

    /**
     * Update a survey_schedule by ID.
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
        $survey_schedule = SurveySchedule::findOrFail($id);
        $survey_schedule->fill($attrs);

        if (!$survey_schedule->isValidFor('UPDATE')) {
            throw new ValidationException($survey_schedule->validator());
        }

        $survey_schedule->save();

        return fractal($survey_schedule, new SurveyScheduleTransformer())->toArray();
    }

    /**
     * Delete a survey_schedule by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $survey_schedule = SurveySchedule::findOrFail($id);

        return (bool) $survey_schedule->delete();
    }
}

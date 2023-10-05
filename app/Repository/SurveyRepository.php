<?php

namespace App\Repository;

use App\Models\Chiller;
use App\Models\Merchant;
use App\Models\Product;
use App\Models\ProductChiller;
use App\Models\Survey;
use App\Models\SurveyDetail;
use App\Models\SurveyProduct;
use App\Transformers\SurveyTransformer;
use App\Transformers\SurveyDetailTransformer;
use App\Transformers\SurveyProductTransformer;
use App\Transformers\SurveyShowTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SurveyRepository
{
    /**
     * Get list of paginated surveys.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $surveys = Survey::filter($request)->paginate($request->get('per_page', 20));

        return fractal($surveys, new SurveyTransformer())->toArray();
    }

    /**
     * Get a survey by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $survey = Survey::where('schedule_id', $id)->first();
        if ($survey == null) {
            $survey = new Survey();
        }

        return fractal($survey, new SurveyShowTransformer())->toArray();
    }

    public function getDetail(Request $request)
    {
        $survey = Survey::where('schedule_id', $request->schedule_id)->firstOrFail();
        $survey_detail = SurveyDetail::where('survey_id', $survey->id)
            ->where('chiller_id', $request->chiller_id)
            ->first();

        return $survey_detail;
    }

    public function getDetailChiller(Request $request): array
    {
        $survey_detail = $this->getDetail($request);
        return fractal($survey_detail, new SurveyDetailTransformer())->toArray();
    }

    public function getDetailProducts(Request $request): array
    {
        $survey_detail = $this->getDetail($request);
        return fractal($survey_detail, new SurveyProductTransformer())->toArray();
    }

    public function chillerMaintenance(int $chiller_id): array
    {
        $chiller = Chiller::findOrFail($chiller_id);
        $survey_detail = SurveyDetail::where('chiller_id', $chiller_id)
            ->where('chiller_maintenance', 1)
            ->orderBy('id', 'desc')
            ->first();

        $last_maintenance = $upcoming_maintenance = null;
        if ($survey_detail != null) {
            $last_maintenance = Carbon::parse($survey_detail->created_at);
            $upcoming_maintenance = $last_maintenance->copy()->addMonths(3);
        }

        return [
            'chiller_id' => $chiller->id,
            'merchant_id' => $chiller->merchant_id,
            'last_maintenance' => $last_maintenance->format('Y-m-d'),
            'upcoming_maintenance' => $upcoming_maintenance->format('Y-m-d'),
        ];
    }

    /**
     * Store a new survey.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $survey = new Survey($attrs);
        if (!$survey->isValidFor('CREATE')) {
            throw new ValidationException($survey->validator());
        }

        $survey->save();

        return fractal($survey, new SurveyTransformer())->toArray();
    }

    /**
     * Update a survey by ID.
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
        $survey = Survey::findOrFail($id);
        $survey->fill($attrs);
        $survey->save();

        return fractal($survey, new SurveyTransformer())->toArray();
    }

    public function closedById(int $id): array
    {
        $survey = Survey::findOrFail($id);
        $survey->fill(['is_closed' => 1]);
        $survey->save();

        $survey->schedule->update(['status' => 2]);
        $survey->schedule->merchant->update([
            'is_closed' => true,
            'is_closed_time' => date('Y-m-d H:i:s'),
        ]);

        return fractal($survey, new SurveyTransformer())->toArray();
    }


    public function addChiller(int $id, array $attrs): array
    {
        $survey = Survey::findOrFail($id);
        $attrs["survey_id"] = $survey->id;
        $survey_detail = new SurveyDetail($attrs);
        $survey_detail->save();

        return fractal($survey, new SurveyTransformer())->toArray();
    }

    public function addProducts(int $id, array $attrs): array
    {
        $survey = Survey::findOrFail($id);

        // update survey chiller data
        $survey_detail = SurveyDetail::where("survey_id", $id)
            ->where("chiller_id", $attrs["chiller_id"])
            ->firstOrFail();

        $survey_detail->fill($attrs);
        $survey_detail->save();

        foreach ($attrs['products'] as $product) {
            $product_chiller = ProductChiller::where('id', $product['product_chiller_id'])->firstOrFail();
            $product["product_id"] = $product_chiller->product_id;
            $product["survey_detail_id"] = $survey_detail->id;
            $survey_product = new SurveyProduct($product);
            $survey_product->save();

            // update product chiller stock
            $survey_product->product_chiller->update(['stock' => $product['stock']]);
        }

        $survey->schedule->update(['status' => 1]);

        return fractal($survey, new SurveyTransformer())->toArray();
    }

    /**
     * Delete a survey by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $survey = Survey::findOrFail($id);

        return (bool) $survey->delete();
    }

    /**
     * Get list of reports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getReports(Request $request): array
    {
        $surveys = Survey::filterReport($request)->get();

        $take_photo_of_chiller = $this->formatReport(["NO", "YES"]);
        $chiller_is_placed_in_the_agreed_spot = $this->formatReport(["NO", "YES"]);
        $chiller_condition = $this->formatReport(["BAIK", "PERLU PERBAIKAN", "RUSAK"]);
        $chiller_maintenance = $this->formatReport(["NO", "YES"]);
        $check_chiller_branding = $this->formatReport(["NO", "YES"]);
        $keep_chiller_clean = $this->formatReport(["NO", "YES"]);
        $planogram = $this->formatReport(["NO", "YES"]);

        $product_ids = array();
        $product_names = array();
        $products = Product::where('is_sales', 0)->get();
        foreach ($products as $product) {
            $product_names[] = strtoupper(explode(" ", $product->name)[0]);
            $product_ids[] = $product->id;
        }

        $daily_inventory = $this->formatReport($product_names);
        $share_of_space = $this->formatReport($product_names);
        $on_shelf_availability = [
            "data_true" => $this->formatReport($product_names),
            "data_false" => $this->formatReport($product_names)
        ];

        foreach ($surveys as $survey) {
            // take_photo_of_chiller
            $is_not_checkin = $survey->checkin_photo == null || $survey->checkin_photo == "" || $survey->checkin_photo == "-";
            $checkin_index = $is_not_checkin ? 0 : 1;
            $take_photo_of_chiller[$checkin_index]["total"]++;

            foreach ($survey->details as $detail) {
                // chiller_is_placed_in_the_agreed_spot
                $chiller_is_placed_in_the_agreed_spot[$detail->chiller_placement]["total"]++;

                // chiller_condition
                if ($detail->chiller_condition == "A") {
                    $chiller_condition_index = 0;
                } else if ($detail->chiller_condition == "B") {
                    $chiller_condition_index = 1;
                } else {
                    $chiller_condition_index = 2;
                }

                $chiller_condition[$chiller_condition_index]["total"]++;

                // chiller_maintenance
                $chiller_maintenance[$detail->chiller_maintenance]["total"]++;

                // check_chiller_branding
                $check_chiller_branding[$detail->chiller_branding]["total"]++;

                // keep_chiller_clean
                $keep_chiller_clean[$detail->chiller_cleanliness]["total"]++;

                // planogram
                $planogram[$detail->planogram]["total"]++;

                foreach ($detail->products as $survey_product) {
                    $key = array_search($survey_product->product_chiller->product_id, $product_ids);

                    // daily_inventory
                    $daily_inventory[$key]["total"] += $survey_product->stock;

                    // share_of_space
                    $share_of_space[$key]["total"] += $survey_product->sos;

                    // on_shelf_availability
                    if ($survey_product->status) {
                        $on_shelf_availability["data_true"][$key]["total"]++;
                    } else {
                        $on_shelf_availability["data_false"][$key]["total"]++;
                    }
                }
            }
        }

        $take_photo_of_chiller = $this->formatReportValue($take_photo_of_chiller);
        $chiller_is_placed_in_the_agreed_spot = $this->formatReportValue($chiller_is_placed_in_the_agreed_spot);
        $chiller_condition = $this->formatReportValue($chiller_condition);
        $chiller_maintenance = $this->formatReportValue($chiller_maintenance);
        $check_chiller_branding = $this->formatReportValue($check_chiller_branding);
        $keep_chiller_clean = $this->formatReportValue($keep_chiller_clean);
        $planogram = $this->formatReportValue($planogram);
        $daily_inventory = $this->formatReportValue($daily_inventory);
        $share_of_space = $this->formatReportValue($share_of_space);
        $on_shelf_availability = $this->formatOsaReport($on_shelf_availability);

        $reports = compact(
            'take_photo_of_chiller',
            'chiller_is_placed_in_the_agreed_spot',
            'check_chiller_branding',
            'keep_chiller_clean',
            'chiller_condition',
            'chiller_maintenance',
            'on_shelf_availability',
            'planogram',
            'share_of_space',
            'daily_inventory',
        );

        return $reports;
    }

    private function defaultReportData($label)
    {
        return [
            "label" => $label,
            "total" => 0,
            "value" => ""
        ];
    }

    private function formatReport($labels)
    {
        $format = array();
        foreach ($labels as $label) {
            $format[] = $this->defaultReportData($label);
        }

        return $format;
    }

    private function formatReportValue($data)
    {
        $items = array();
        $grand_total = 0;
        foreach ($data as $item) {
            $grand_total += $item["total"];
        }

        foreach ($data as $item) {
            $percentage = $grand_total > 0 ? round($item["total"] / $grand_total * 100) : 0;
            $item["value"] = (string) $percentage . "%";
            $items[] = $item;
        }

        return $items;
    }

    private function formatOsaReport($data)
    {
        $count_data = count($data['data_true']);
        $grand_total_true = 0;
        $grand_total_false = 0;
        if ($count_data > 0) {
            foreach (range(0,  $count_data - 1) as $index) {
                $total = $data['data_true'][$index]["total"] + $data['data_false'][$index]["total"];
                if ($total != 0) {
                    $percentage_true = round($data['data_true'][$index]["total"] / $total * 100);
                    $percentage_false = round($data['data_false'][$index]["total"] / $total * 100);

                    $data['data_true'][$index]["value"] = (string) $percentage_true . "%";
                    $data['data_false'][$index]["value"] = (string) $percentage_false . "%";

                    $grand_total_true += $data['data_true'][$index]["total"];
                    $grand_total_false += $data['data_false'][$index]["total"];
                }
            }
        }

        $grand_total = $grand_total_true + $grand_total_false;
        $percentage_true = $grand_total > 0 ? round($grand_total_true / ($grand_total) * 100) : 0;
        $data['data_true'][] = [
            "label" => "TOTAL",
            "total" => $grand_total_true,
            "value" => (string) $percentage_true . "%"
        ];

        $percentage_false = $grand_total > 0 ? round($grand_total_false / ($grand_total) * 100) : 0;
        $data['data_false'][] = [
            "label" => "TOTAL",
            "total" => $grand_total_false,
            "value" => (string) $percentage_false . "%"
        ];

        return $data;
    }
}

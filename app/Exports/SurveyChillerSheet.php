<?php

namespace App\Exports;

use App\Models\SurveyDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SurveyChillerSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $start_date;
    protected $end_date;

    public function __construct(string $start_date, string $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /**
     * @return Array
     * Modify data from collection before exporting to excel
     */
    public function map($data): array
    {
        return [
            $data->chiller_photo,
            $data->chiller_placement,
            $data->chiller_placement_note,
            $data->chiller_branding,
            $data->chiller_branding_note,
            $data->chiller_cleanliness,
            $data->chiller_cleanliness_note,
            $data->chiller_condition,
            $data->chiller_condition_note,
            $data->chiller_maintenance,
            $data->chiller_maintenance_note,
        ];
    }

    public function headings(): array
    {
        return [
            "Foto Chiller",
            "Penempatan Chiller",
            "Catatan Penempatan Chiller",
            "Merk Chiller",
            "Catatan Merk Chiller",
            "Kebersihan Chiller",
            "Catatan Kebersihan Chiller",
            "Kondisi Chiller",
            "Catatan Kondisi Chiller",
            "Maintance Chiller",
            "Catatan Maintance Chiller",
        ];
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $surveyDetails = SurveyDetail::query()
            ->whereBetween('created_at', [$this->start_date, $this->end_date])
            ->get();

        return $surveyDetails->map(function ($surveyDetail) {
            return $this->map($surveyDetail);
        });
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'survey_chiller';
    }
}

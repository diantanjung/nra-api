<?php

namespace App\Exports;

use App\Models\Survey;
use App\Models\Merchant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SurveyDataSheet implements FromCollection, WithTitle, WithHeadings
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
        // dd($data);
        $survey = Survey::findOrFail($data->id);
        $user = $survey->user()->find($data->user_id);
        $schedule = $survey->schedule()->find($data->schedule_id);
        $merchant = Merchant::findOrFail($schedule->merchant_id);
        $status = Survey::statusList()[$data->status];
        $status_merchant = 'Buka';
        if ($survey->is_closed == true) {
            $status_merchant = 'Tutup';
        }

        return [
            $schedule->date_time,
            $user->name,
            $merchant->name,
            $merchant->address,
            $status,
            $status_merchant,
            $survey->checkin_photo,
        ];
    }

    public function headings(): array
    {
        return [
            "Schedule Date",
            "User Name",
            "Nama Toko",
            "Alamat Toko",
            "Status",
            "Buka / Tutup",
            "Foto Pengecekan",
        ];
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $surveys = Survey::query()
            ->whereBetween('log_start', [$this->start_date, $this->end_date])
            ->get();

        return $surveys->map(function ($survey) {
            return $this->map($survey);
        });
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'survey_data';
    }
}

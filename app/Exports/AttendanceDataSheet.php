<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AttendanceDataSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $start_date;
    protected $end_date;
    protected $client_id;

    public function __construct(string $start_date, string $end_date, int $client_id)
    {
        $this->client_id = $client_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /**
     * @return Array
     * Modify data from collection before exporting to excel
     */
    public function map($data): array
    {
        $in_log_start = Carbon::parse($data->in_log_start);
        $in_log_end = Carbon::parse($data->in_log_end);
        $out_log_start = Carbon::parse($data->out_log_start);
        $out_log_end = Carbon::parse($data->out_log_end);

        // perlu dicek jika telat berarti in log end di atas in log start atau tidak
        $late_in = $in_log_start->diff($in_log_end);
        $early_out = $out_log_end->diff($out_log_start);
        $actual_working_hour = $in_log_end->diff($out_log_end);
        $schedule_working_hour = $in_log_start->diff($out_log_start);
        $ot_duration = $out_log_start->diff($out_log_end);

        return [
            $data->user->name,
            $data->user->profile->nip,
            $data->user->client->name,
            $data->user->profile->department->name,
            $data->user->profile->title,
            $in_log_start->copy()->format('d-m-Y'),
            $data->shift_label,
            $in_log_start->copy()->format('d-m-Y H:i'),
            $out_log_start->copy()->format('d-m-Y H:i'),
            $data->type,
            '-',
            $data->in_log_end,
            $data->out_log_end,
            $late_in->i . ' Menit',
            $early_out->h . ' Jam ' . $early_out->i . ' Menit',
            $schedule_working_hour->h . ' Jam ' . $schedule_working_hour->i . ' Menit',
            $actual_working_hour->h . ' Jam ' . $actual_working_hour->i . ' Menit',
            $data->out_log_start,
            $data->out_log_end,
            $ot_duration->h . ' Jam ' . $ot_duration->i . ' Menit',
            $ot_duration->h . ' Jam ' . $ot_duration->i . ' Menit', // actual check in lembur
        ];
    }

    public function headings(): array
    {
        return [
            'Full Name',
            'NIP',
            'Client',
            'Department',
            'Job Position',
            'Date',
            'Shift',
            'Schedule Check In',
            'Schedule Check Out',
            'Attendance Code',
            'Time Off Code',
            'Check In',
            'Check Out',
            'Late In',
            'Early Out',
            'Schedule Working Hour',
            'Actual Working Hour',
            'Check In Lembur',
            'Check Out Lembur',
            'Overtime Duration',
            'Actual Check In Lembur',
            'Overtime Duration Adjustment'
        ];
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $attendances = Attendance::query()
            ->where('client_id', $this->client_id)
            ->whereBetween('in_log_start', [$this->start_date, $this->end_date])
            ->get();

        return $attendances->map(function ($attendance) {
            return $this->map($attendance);
        });
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Attendance data';
    }
}

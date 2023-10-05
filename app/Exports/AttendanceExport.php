<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AttendanceExport implements WithMultipleSheets
{
    use Exportable;

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
     * @return array
     */
    public function sheets(): array
    {
        $sheets = array();
        $end_date = Carbon::parse($this->end_date)->addDay()->format('Y-m-d');
        $sheets[] = new AttendanceDataSheet($this->start_date, $end_date, $this->client_id);

        return $sheets;
    }
}

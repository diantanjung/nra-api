<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SurveyExport implements WithMultipleSheets
{
    use Exportable;

    protected $start_date;
    protected $end_date;

    public function __construct(string $start_date, string $end_date)
    {
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
        $sheets[] = new SurveyDataSheet($this->start_date, $end_date);
        $sheets[] = new SurveyChillerSheet($this->start_date, $end_date);
        $sheets[] = new SurveyProductSheet($this->start_date, $end_date);
        $sheets[] = new ProductMasterSheet();

        return $sheets;
    }
}

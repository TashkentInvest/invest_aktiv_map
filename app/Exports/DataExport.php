<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\Shartnoma;
use App\Models\TolovGrafigi;
use App\Models\Branch;
use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataExport implements FromQuery, WithHeadings
{
    protected $columns;

    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    public function query()
    {
        // Customize this query to fetch the data you need
        // For example:
        return Client::query()->select($this->columns);
    }

    public function headings(): array
    {
        return $this->columns;
    }
}
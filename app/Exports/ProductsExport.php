<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductsExport implements FromCollection, WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    protected $id;
    protected $startDate;
    protected $endDate;
    protected $selectedColumns;

    public function __construct($id = null, $startDate = null, $endDate = null, $selectedColumns = [])
    {
        $this->id = $id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->selectedColumns = $selectedColumns;
    }

    public function collection()
    {
        try {
            $query = DB::table('clients')
                ->join('companies', 'clients.id', '=', 'companies.client_id')
                ->join('branches', 'clients.id', '=', 'branches.client_id')
                ->join('addresses', 'clients.id', '=', 'addresses.client_id')
                ->select($this->buildSelectColumns());

            $query->where('clients.is_deleted', '!=', 1);

            if ($this->id !== null) {
                $query->where('clients.id', $this->id);
            }

            if ($this->startDate !== null && $this->endDate !== null) {
                $query->whereBetween('clients.updated_at', [$this->startDate, $this->endDate]);
            }

            $collection = $query->get();

            // Remove the 'number' attribute
            $collection->each(function ($item) {
                unset($item->number);
            });

            return $collection->map(function ($item) {
                return (array) $item;
            });
        } catch (\Exception $e) {
            \Log::error('Error exporting products: ' . $e->getMessage());
            return collect([]);
        }
    }

    protected function buildSelectColumns()
    {
        $columns = [
            'application_number' => 'branches.application_number AS application_number',
            'contract_number' => 'branches.contract_apt AS contract_number',
            'contract_date' => 'branches.contract_date AS contract_date',
            'notification_number' => 'branches.notification_num AS notification_number',
            'company_name' => 'companies.company_name AS company_name',
            'district' => 'addresses.yuridik_address AS district',
            'home_district' => 'addresses.home_address AS home_district',
            'calculated_volume' => 'branches.branch_kubmetr AS calculated_volume',
            'infrastructure_payment' => 'branches.generate_price AS infrastructure_payment',
            'percentage_input' => 'branches.percentage_input AS percentage_input',
            'paid_amount' => 'branches.payed_sum AS paid_amount',
            'payment_date' => 'branches.payed_date AS payment_date',
            'notification_date' => 'branches.notification_date AS notification_date',
            'branch_name' => 'branches.branch_name AS branch_name',
            'branch_type' => 'branches.branch_type AS branch_type',
            'branch_location' => 'branches.branch_location AS branch_location',
            'insurance_policy' => 'branches.insurance_policy AS insurance_policy',
            'bank_guarantee' => 'branches.bank_guarantee AS bank_guarantee',
            'contact' => 'clients.contact AS contact',
            'note' => 'clients.client_description AS note'
        ];
    
        return array_intersect_key($columns, array_flip($this->selectedColumns));
    }
    
    public function headings(): array
    {
        $headings = [
            'number' => '№',
            'application_number' => 'Номер заявления',
            'contract_number' => '№ договора',
            'contract_date' => 'Дата договора',
            'notification_number' => '№ разрешения',
            'company_name' => 'Наименование организации',
            'district' => 'Юридический адрес',
            'home_district' => 'Домашний адрес',
            'calculated_volume' => 'Расчетный объем здания',
            'infrastructure_payment' => 'Инфраструктурный платеж (сўм) по договору',
            'percentage_input' => 'Процент предоплаты при рассрочке (%)',
            'paid_amount' => 'Оплаченная сумма (сўм)',
            'payment_date' => 'Дата оплаты',
            'notification_date' => 'Дата уведомления',
            'branch_name' => 'Название объекта',
            'branch_type' => 'Тип объекта',
            'branch_location' => 'Местоположение объекта',
            'insurance_policy' => 'Страховой полис',
            'bank_guarantee' => 'Банковская гарантия',
            'contact' => 'Контакты',
            'note' => 'Примечание'
        ];

        return array_values(array_intersect_key($headings, array_flip($this->selectedColumns)));
    }

    public function columnFormats(): array
    {
        $formats = [
            'A' => '@',
            'B' => '@',
            'C' => '@',
            'D' => '@',
            'E' => '@',
            'F' => '@',
            'G' => '@',
            'H' => '@',
            'I' => '@',
            'J' => '@',
            'K' => '@',
            'L' => '@',
            'M' => '@',
            'N' => '@',
            'O' => '@',
            'P' => '@',
            'Q' => '@'
        ];

        $alphabet = range('A', 'Z');
        $selectedFormats = [];

        foreach (array_keys($this->selectedColumns) as $index => $column) {
            $selectedFormats[$alphabet[$index]] = '@';
        }

        return $selectedFormats;
    }
}

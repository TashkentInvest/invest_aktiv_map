<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Client;
use App\Models\Company;
use App\Models\Order;
use App\Models\Ruxsatnoma;
use App\Models\Shartnoma;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $filter = $request->input('filter', ''); // Default to an empty string if not provided
        $sort = $request->input('sort', 'created_at');

        $results = collect();

        switch ($filter) {
            case 'clients':
                $results = Client::where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('first_name', 'like', "%{$query}%")
                        ->orWhere('last_name', 'like', "%{$query}%")
                        ->orWhere('contact', 'like', "%{$query}%");
                })->orderBy($this->getSortColumn($sort), $this->getSortDirection($sort))
                    ->get();
                break;

            case 'companies':
                $results = Company::where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('company_name', 'like', "%{$query}%")
                        ->orWhere('oked', 'like', "%{$query}%")
                        ->orWhere('home_number', 'like', "%{$query}%")
                        ->orWhere('apartment_number', 'like', "%{$query}%");
                })->orderBy($this->getSortColumn($sort), $this->getSortDirection($sort))
                    ->get();
                break;

            case 'orders':
                $results = Order::where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('unique_code', 'like', "%{$query}%");
                })->orderBy($this->getSortColumn($sort), $this->getSortDirection($sort))
                    ->get();
                break;

            case 'branches':
                $results = Branch::where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('id', 'like', "%{$query}%")
                        ->orWhere('sub_street_id', 'like', "%{$query}%");
                })->orderBy($this->getSortColumn($sort), $this->getSortDirection($sort))
                    ->get();
                break;

            case 'shartnomas':
                $results = Shartnoma::where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('shartnoma_raqami', 'like', "%{$query}%");
                })->with('branch') // Include the branch relation
                ->orderBy($this->getSortColumn($sort), $this->getSortDirection($sort))
                    ->get();
                break;

            case 'ruxsatnomas':
                $results = Ruxsatnoma::where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('ruxsat_etuvchi_hujjat_raqami', 'like', "%{$query}%")
                        ->orWhere('kadastr_raqami', 'like', "%{$query}%");
                })->orderBy($this->getSortColumn($sort), $this->getSortDirection($sort))
                    ->get();
                break;

            default:
                $results = collect();
                break;
        }

        return view('pages.search.index', [
            'clients' => $filter === 'clients' ? $results : [],
            'companies' => $filter === 'companies' ? $results : [],
            'orders' => $filter === 'orders' ? $results : [],
            'branches' => $filter === 'branches' ? $results : [],
            'shartnomas' => $filter === 'shartnomas' ? $results : [],
            'ruxsatnomas' => $filter === 'ruxsatnomas' ? $results : [],
            'filter' => $filter
        ]);
    }

    private function getSortColumn($sort)
    {
        switch ($sort) {
            case 'hits_high_low':
                return 'hits';
            case 'hits_low_high':
                return 'hits';
            case 'popularity':
                return 'popularity';
            case 'fresh_arrivals':
                return 'created_at';
            default:
                return 'created_at';
        }
    }

    private function getSortDirection($sort)
    {
        return in_array($sort, ['hits_high_low']) ? 'desc' : 'asc';
    }
}

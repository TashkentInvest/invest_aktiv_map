<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Category;
use App\Models\Client;
use App\Models\Company;
use App\Models\Regions;
use App\Models\RuxsatnomaBerilganIshTuri;
use App\Models\RuxsatnomaKimTamonidan;
use App\Models\RuxsatnomaTuri;
use App\Models\SubyektShakli;
use App\Models\XujjatBerilganJoyi;
use App\Models\XujjatTuri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // public function index(){
    //     return view('pages.products.index');
    // }
    public function index()
    {
        $clients = Client::deepFilters()
            ->with(['company', 'branches'])
            ->where('is_deleted', '!=', 1)
            ->orderByDesc('id')
            ->paginate(25);
            
        return view('pages.products.index', compact('clients'));
    }
    
    public function add_fizik()
    {
        $ruxsatnoma_turi = RuxsatnomaTuri::all();
        $ruxsatnoma_kim_tamonidan = RuxsatnomaKimTamonidan::all();
        $ruxsatnoma_berilgan_ish_turi = RuxsatnomaBerilganIshTuri::all(); 
        $xujjatTurlari = XujjatTuri::get()->all();
        $xujjatBerilganJoyi = XujjatBerilganJoyi::get()->all();
        $categories = Category::get()->all();
        $regions = Regions::get()->all();
        return view('pages.products.add_fizik', compact('regions','categories','xujjatTurlari','xujjatBerilganJoyi','ruxsatnoma_turi','ruxsatnoma_kim_tamonidan','ruxsatnoma_berilgan_ish_turi'));
    }

    public function add_yuridik()
    {
        $subyektShakli = SubyektShakli::get()->all();
        $categories = Category::get()->all();
        $regions = Regions::get()->all();
        return view('pages.products.add_yuridik', compact('regions','categories','subyektShakli'));
    }

 
    
    
}

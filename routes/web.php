<?php

use App\Http\Controllers\AktivController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KjController;
use App\Http\Controllers\KoController;
use App\Http\Controllers\KtController;
use App\Http\Controllers\KzController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ObyektController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StreetController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\SubStreetController;
use App\Http\Controllers\Blade\HomeController;
use App\Http\Controllers\Blade\RoleController;
use App\Http\Controllers\Blade\UserController;
use App\Http\Controllers\XujjatTuriController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Blade\ClientController;
use App\Http\Controllers\Blade\RegionController;
use App\Http\Controllers\ConstructionController;
use App\Http\Controllers\NumberToTextController;
use App\Http\Controllers\Blade\ApiUserController;
use App\Http\Controllers\SubyektShakliController;
use App\Http\Controllers\Blade\DistrictController;
use App\Http\Controllers\RuxsatnomaTuriController;
use App\Http\Controllers\Blade\PermissionController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\FactPaymentController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\OrderAtkazController;
use App\Http\Controllers\XujjatBerilganJoyiController;
use App\Http\Controllers\RuxsatnomaKimTamonidanController;
use App\Http\Controllers\RuxsatnomaBerilganIshTuriController;
use App\Http\Controllers\ShartnomaController;
use App\Http\Controllers\SubyektController;

// Default laravel auth routes
Auth::routes(['register' => false]);

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

Route::get('/client/create', [ClientController::class, 'client_create'])->name('clientFormCreate');
Route::post('/qr/create', [ClientController::class, 'Qrcreate'])->name('Qrcreate');
Route::get('/number-to+-text', [NumberToTextController::class, 'convert']);



Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/statistics', [HomeController::class, 'statistics'])->name('statistics.show');
// Web pages
Route::group(['middleware' => ['auth', 'checkUserRole']], function () {

    Route::get('aktivs', [AktivController::class, 'index'])->name('aktivs.index');
    Route::get('aktivs/create', [AktivController::class, 'create'])->name('aktivs.create');
    Route::post('aktivs', [AktivController::class, 'store'])->name('aktivs.store');
    Route::get('aktivs/{aktiv}', [AktivController::class, 'show'])->name('aktivs.show');
    Route::get('aktivs/{aktiv}/edit', [AktivController::class, 'edit'])->name('aktivs.edit');
    Route::put('aktivs/{aktiv}', [AktivController::class, 'update'])->name('aktivs.update');
    Route::delete('aktivs/{aktiv}', [AktivController::class, 'destroy'])->name('aktivs.destroy');
    Route::get('aktiv/users', [AktivController::class, 'userAktivCounts'])->name('aktivs.userAktivCounts');
    Route::get('aktiv/tumanlar', [AktivController::class, 'userTumanlarCounts'])->name('aktivs.userTumanlarCounts');
    Route::post('/aktivs/export', [AktivController::class, 'export'])->name('aktivs.export');


    Route::get('/my-map', [AktivController::class, 'myMap'])->name('aktivs.myMap');

    // Route::get('maps/aktivs', [AktivController::class, 'getLots']);


    Route::get('/optimize-cache', [HomeController::class, 'optimize'])->name('optimize.command');

    // Regions  
    // Route::prefix('regions')->group(function () {
    //     Route::get('/', [RegionController::class, 'index'])->name('regionIndex');
    //     Route::get('/add', [RegionController::class, 'add'])->name('regionAdd');
    //     Route::post('/create', [RegionController::class, 'create'])->name('regionCreate');
    //     Route::get('/edit/{id}', [RegionController::class, 'edit'])->name('regionEdit');
    //     Route::post('/update/{id}', [RegionController::class, 'update'])->name('regionUpdate');
    //     Route::delete('/delete/{id}', [RegionController::class, 'destroy'])->name('regionDestroy');
    // });

    // Districts 
    // Route::prefix('districts')->group(function () {
    //     Route::get('/', [DistrictController::class, 'index'])->name('districtIndex');
    //     Route::get('/add', [DistrictController::class, 'add'])->name('districtAdd');
    //     Route::post('/create', [DistrictController::class, 'create'])->name('districtCreate');
    //     Route::get('/edit/{id}', [DistrictController::class, 'edit'])->name('districtEdit');
    //     Route::post('/update/{id}', [DistrictController::class, 'update'])->name('districtUpdate');
    //     Route::delete('/delete/{id}', [DistrictController::class, 'destroy'])->name('districtDestroy');
    // });
    // Products
    // Route::prefix('clients')->group(function () {
    //     Route::get('/', [ClientController::class, 'index'])->name('clientIndex');

    //     Route::get('/data', [ClientController::class, 'getClientsData'])->name('clients.data');
    //     Route::get('/add/fizik', [ClientController::class, 'add_fizik'])->name('clientFizikAdd');
    //     Route::get('/add/yuridik', [ClientController::class, 'add_yuridik'])->name('clientYuridikAdd');
    //     Route::get('/{id}', [ClientController::class, 'show'])->name('clientDetails');
    //     Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('clientFizikEdit');
    //     Route::post('/create', [ClientController::class, 'create'])->name('clientCreate');
    //     Route::delete('/delete/{id}', [ClientController::class, 'delete'])->name('clientDestroy');
    //     Route::match(['put', 'post'], 'product/{id}', [ClientController::class, 'update'])->name('clientUpdate');
    //     Route::post('/toggle-status/{id}', [ClientController::class, 'toggleclientActivation'])->name('clientActivation');
    // });
    Route::get('/apz-second', [ClientController::class, 'apz_second'])->name('apz.second');
    Route::get('/client/confirm', [ClientController::class, 'client_confirm'])->name('clientFormConfirm');

    // Permissions
    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissionIndex');
        Route::get('/add', [PermissionController::class, 'add'])->name('permissionAdd');
        Route::post('/create', [PermissionController::class, 'create'])->name('permissionCreate');
        Route::get('/{id}/edit', [PermissionController::class, 'edit'])->name('permissionEdit');
        Route::post('/update/{id}', [PermissionController::class, 'update'])->name('permissionUpdate');
        Route::delete('/delete/{id}', [PermissionController::class, 'destroy'])->name('permissionDestroy');
    });
    // Roles
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roleIndex');
        Route::get('/add', [RoleController::class, 'add'])->name('roleAdd');
        Route::post('/create', [RoleController::class, 'create'])->name('roleCreate');
        Route::get('/{role_id}/edit', [RoleController::class, 'edit'])->name('roleEdit');
        Route::post('/update/{role_id}', [RoleController::class, 'update'])->name('roleUpdate');
        Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('roleDestroy');
    });
    // ApiUsers
    Route::prefix('api-users')->group(function () {
        Route::get('/', [ApiUserController::class, 'index'])->name('api-userIndex');
        Route::get('/add', [ApiUserController::class, 'add'])->name('api-userAdd');
        Route::post('/create', [ApiUserController::class, 'create'])->name('api-userCreate');
        Route::get('/show/{id}', [ApiUserController::class, 'show'])->name('api-userShow');
        Route::get('/{id}/edit', [ApiUserController::class, 'edit'])->name('api-userEdit');
        Route::post('/update/{id}', [ApiUserController::class, 'update'])->name('api-userUpdate');
        Route::delete('/delete/{id}', [ApiUserController::class, 'destroy'])->name('api-userDestroy');
        Route::delete('-token/delete/{id}', [ApiUserController::class, 'destroyToken'])->name('api-tokenDestroy');
    });
    // import
    Route::prefix('import')->group(function () {
        Route::get('/', [ImportController::class, 'index'])->name('import');
        Route::post('/', [ImportController::class, 'import'])->name('import.xls');
        Route::post('_debat', [ImportController::class, 'import_debat'])->name('import_debat.xls');
        Route::post('_credit', [ImportController::class, 'import_credit'])->name('import_credit.xls');
    });
    // Transactions
    Route::prefix('transactions')->group(function () {
        Route::get('/all', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/art', [TransactionController::class, 'art'])->name('transactions.art');
        Route::get('/ads', [TransactionController::class, 'ads'])->name('transactions.ads');
        Route::get('/payers', [TransactionController::class, 'payers'])->name('transactions.payers');
        Route::get('/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    });
    // Backup
    Route::prefix('backups')->group(function () {
        Route::get('/', [BackupController::class, 'index'])->name('backup.index');
        Route::get('/{id}', [BackupController::class, 'show'])->name('backup.show');
        Route::any('/download/{filename}', [BackupController::class, 'download'])->name('backup.download');
        Route::delete('/{filename}', [BackupController::class, 'delete'])->name('backup.delete');
        Route::any('/backup-delete', [BackupController::class, 'deleteAll'])->name('backup.deleteAll');
    });
    // File
    Route::get('/test/download', [FileController::class, 'downloadDocument'])->name('download.document');
    Route::prefix('files')->group(function () {
        Route::get('/doc/{id}', [FileController::class, 'show'])->name('word');
        Route::get('/test/{id}', [FileController::class, 'test'])->name('test.word');

        Route::get('/downloading-excel/{id}', [FileController::class, 'downloadTableData'])->name('download.table.data');
        Route::get('/select-columns', [FileController::class, 'showColumnSelectionForm'])->name('select.columns');
        Route::get('/download-excel', [FileController::class, 'downloadExcel'])->name('download.excel');
    });

    // History
    Route::get('/histories', [HistoryController::class, 'index'])->name('histories.index');

    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/request-confirm', [HistoryController::class, 'confirm'])->name('request.confirm');
    Route::get('/history/{id}', [HistoryController::class, 'showHistory'])->name('history.show');



    Route::get('/import/backup', [BackupController::class, 'import'])->name('backup.import');
});

Route::group(['middleware' => ['auth']], function () {
    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('userIndex');
        Route::get('/add', [UserController::class, 'add'])->name('userAdd');
        Route::post('/create', [UserController::class, 'create'])->name('userCreate');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('userEdit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('userUpdate');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('userDestroy');
        Route::get('/theme-set/{id}', [UserController::class, 'setTheme'])->name('userSetTheme');
    });
    Route::post('user/update/users', [UserController::class, 'updateUserNames'])->name('userUpdateNames');
    // Constructions
    Route::prefix('constructions')->group(function () {
        Route::get('/', [ConstructionController::class, 'index'])->name('construction.index');
        Route::get('/{id}', [ConstructionController::class, 'show'])->name('construction.show');
        Route::get('/{id}/edit', [ConstructionController::class, 'edit'])->name('construction.edit');
        Route::any('/update/{id}', [ConstructionController::class, 'update'])->name('construction.update');
        Route::post('/update-status', [ConstructionController::class, 'updateStatus'])->name('updateStatus');
    });

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::put('/chat/{id}', [ChatController::class, 'update'])->name('chat.update');
    Route::delete('/chat/{id}', [ChatController::class, 'destroy'])->name('chat.destroy');
});
Route::get('/gerb/{id}', [FileController::class, 'gerb'])->name('file.mobile');
Route::get('/dopShow/{id}', [FileController::class, 'dop'])->name('dopShow');


Route::get('/language/{lang}', function ($lang) {
    $lang = strtolower($lang);
    if ($lang == 'ru' || $lang == 'uz') {
        session([
            'locale' => $lang
        ]);
    }
    return redirect()->back();
})->name('changelang');

// new -----------------------

Route::get('analytics/index', [AnalyticsController::class, 'index'])->name('analytics.index');
Route::get('analytics/statistic', [AnalyticsController::class, 'statistic'])->name('analytics.statistic');

Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');
Route::get('search', [SearchController::class, 'search'])->name('search');

// Obyekt
Route::get('obyekt', [ObyektController::class, 'index'])->name('obyekt.index');
Route::get('obyekt/add', [ObyektController::class, 'add'])->name('obyekt.add');
Route::get('obyekt/{id}', [ObyektController::class, 'show'])->name('branches.show');
Route::get('obyekt/{id}/edit', [ObyektController::class, 'edit'])->name('branches.edit');
Route::put('obyekt/update/{id}', [ObyektController::class, 'obyekt_update'])->name('obyekt_update');
Route::get('obyekt/arxiv/{id}', [ObyektController::class, 'arxiv'])->name('branchArxiv');


Route::delete('/delete/{id}', [ObyektController::class, 'delete'])->name('branches.destroy');



Route::get('/get-client/{unique_code}', [ObyektController::class, 'getClientByUniqueCode'])->name('get-client-by-unique-code');
Route::post('/obyekt/create/fizik', [ObyektController::class, 'create_fizik_client'])->name('obyekt_create_fizik_client');
Route::post('/obyekt/create/yuridik', [ObyektController::class, 'create_yuridik_client'])->name('obyekt_create_yuridik_client');
Route::get('/search-client', [ObyektController::class, 'searchClient'])->name('search-client');
Route::get('/get-client-details/{client_id}', [ObyektController::class, 'getClientDetails'])->name('get-client-details');
Route::post('/obyekt/obyekt_create', [ObyektController::class, 'obyekt_create'])->name('obyekt_create');
Route::get('/get-districts', [ObyektController::class, 'getDistricts'])->name('get.Obdistricts');
Route::get('/get-streets', [ObyektController::class, 'getStreets'])->name('get.Obstreets');
Route::get('/get-substreets', [ObyektController::class, 'getSubstreets'])->name('get.Obsubstreets');


// product 



// Regions
Route::get('/regions', [RegionController::class, 'index'])->name('regionIndex');
Route::get('/region/add', [RegionController::class, 'add'])->name('regionAdd');
Route::post('/region/create', [RegionController::class, 'create'])->name('regionCreate');
Route::get('/region/edit/{id}', [RegionController::class, 'edit'])->name('regionEdit');
Route::post('/region/update/{id}', [RegionController::class, 'update'])->name('regionUpdate');
Route::delete('/region/delete/{id}', [RegionController::class, 'destroy'])->name('regionDestroy');
// Districts 
Route::get('/districts', [DistrictController::class, 'index'])->name('districtIndex');
Route::get('/district/add', [DistrictController::class, 'add'])->name('districtAdd');
Route::post('/district/create', [DistrictController::class, 'create'])->name('districtCreate');
Route::get('/district/edit/{id}', [DistrictController::class, 'edit'])->name('districtEdit');
Route::post('/district/update/{id}', [DistrictController::class, 'update'])->name('districtUpdate');
Route::delete('/district/delete/{id}', [DistrictController::class, 'destroy'])->name('districtDestroy');
Route::get('/get-districts/{region_id}', [DistrictController::class, 'getDistricts'])->name('get.districts');
Route::get('/get-streets/{district_id}', [DistrictController::class, 'getStreets']);
// streets 
Route::get('/streets', [StreetController::class, 'index'])->name('streetIndex');
Route::get('/street/add', [StreetController::class, 'add'])->name('streetAdd');
Route::post('/street/create', [StreetController::class, 'create'])->name('streetCreate');
Route::get('/street/edit/{id}', [StreetController::class, 'edit'])->name('streetEdit');
Route::post('/street/update/{id}', [StreetController::class, 'update'])->name('streetUpdate');
Route::delete('/street/delete/{id}', [StreetController::class, 'destroy'])->name('streetDestroy');
Route::get('/get-product-by-street/{street_id}', [StreetController::class, 'getProductByStreet'])->name('getProductByStreet');
Route::post('/create/street', [StreetController::class, 'create_new'])->name('create.street');

// Substreet 
Route::get('/substreets', [SubStreetController::class, 'index'])->name('substreetIndex');
Route::get('/substreet/add', [SubStreetController::class, 'add'])->name('substreetAdd');
Route::post('/substreet/create', [SubStreetController::class, 'create'])->name('substreetCreate');
Route::get('/substreet/edit/{id}', [SubStreetController::class, 'edit'])->name('substreetEdit');
Route::post('/substreet/update/{id}', [SubStreetController::class, 'update'])->name('substreetUpdate');
Route::delete('/substreet/delete/{id}', [SubStreetController::class, 'destroy'])->name('substreetDestroy');
Route::post('/create/substreet', [SubStreetController::class, 'create_new'])->name('create.substreet');

// Banks 
Route::get('/banks', [BankController::class, 'index'])->name('bankIndex');
Route::get('/bank/add', [BankController::class, 'add'])->name('bankAdd');
Route::post('/bank/create', [BankController::class, 'create'])->name('bankCreate');
Route::get('/bank/edit/{id}', [BankController::class, 'edit'])->name('bankEdit');
Route::post('/bank/update/{id}', [BankController::class, 'update'])->name('bankUpdate');
Route::delete('/bank/delete/{id}', [BankController::class, 'destroy'])->name('bankDestroy');
Route::post('/create/bank', [BankController::class, 'create_new'])->name('create.bank');



// coefficient start Kj
Route::get('/kjs', [KjController::class, 'index'])->name('kjIndex');
Route::get('/kj/add', [kjController::class, 'add'])->name('kjAdd');
Route::post('/kj/create', [kjController::class, 'create'])->name('kjCreate');
Route::get('/kj/edit/{id}', [kjController::class, 'edit'])->name('kjEdit');
Route::post('/kj/update/{id}', [kjController::class, 'update'])->name('kjUpdate');
Route::delete('/kj/delete/{id}', [kjController::class, 'destroy'])->name('kjDestroy');

// coefficient Ko
Route::get('/kos', [KoController::class, 'index'])->name('koIndex');
Route::get('/ko/add', [koController::class, 'add'])->name('koAdd');
Route::post('/ko/create', [koController::class, 'create'])->name('koCreate');
Route::get('/ko/edit/{id}', [koController::class, 'edit'])->name('koEdit');
Route::post('/ko/update/{id}', [koController::class, 'update'])->name('koUpdate');
Route::delete('/ko/delete/{id}', [koController::class, 'destroy'])->name('koDestroy');

// coefficient Kt
Route::get('/kts', [KtController::class, 'index'])->name('ktIndex');
Route::get('/kt/add', [ktController::class, 'add'])->name('ktAdd');
Route::post('/kt/create', [ktController::class, 'create'])->name('ktCreate');
Route::get('/kt/edit/{id}', [ktController::class, 'edit'])->name('ktEdit');
Route::post('/kt/update/{id}', [ktController::class, 'update'])->name('ktUpdate');
Route::delete('/kt/delete/{id}', [ktController::class, 'destroy'])->name('ktDestroy');

// coefficient kz
Route::get('/kzs', [kzController::class, 'index'])->name('kzIndex');
Route::get('/kz/add', [kzController::class, 'add'])->name('kzAdd');
Route::post('/kz/create', [kzController::class, 'create'])->name('kzCreate');
Route::get('/kz/edit/{id}', [kzController::class, 'edit'])->name('kzEdit');
Route::post('/kz/update/{id}', [kzController::class, 'update'])->name('kzUpdate');
Route::delete('/kz/delete/{id}', [kzController::class, 'destroy'])->name('kzDestroy');

// Subyekt shakli 
Route::get('/subyektshakli', [SubyektShakliController::class, 'index'])->name('subyektShakliIndex');
Route::get('/subyektshakli/add', [SubyektShakliController::class, 'add'])->name('subyektShakliAdd');
Route::post('/subyektshakli/create', [SubyektShakliController::class, 'create'])->name('subyektShakliCreate');
Route::get('/subyektshakli/edit/{id}', [SubyektShakliController::class, 'edit'])->name('subyektShakliEdit');
Route::post('/subyektshakli/update/{id}', [SubyektShakliController::class, 'update'])->name('subyektShakliUpdate');
Route::delete('/subyektshakli/delete/{id}', [SubyektShakliController::class, 'destroy'])->name('subyektShakliDestroy');

// xujjatTurlari
Route::get('/xujjatTurlari', [XujjatTuriController::class, 'index'])->name('xujjatTuriIndex');
Route::get('/xujjatTuri/add', [XujjatTuriController::class, 'add'])->name('xujjatTuriAdd');
Route::post('/xujjatTuri/create', [XujjatTuriController::class, 'create'])->name('xujjatTuriCreate');
Route::get('/xujjatTuri/edit/{id}', [XujjatTuriController::class, 'edit'])->name('xujjatTuriEdit');
Route::post('/xujjatTuri/update/{id}', [XujjatTuriController::class, 'update'])->name('xujjatTuriUpdate');
Route::delete('/xujjatTuri/delete/{id}', [XujjatTuriController::class, 'destroy'])->name('xujjatTuriDestroy');

// xujjatBerilganJoyi
Route::get('/xujjatBerilganJoylari', [XujjatBerilganJoyiController::class, 'index'])->name('xujjatBerilganJoyiIndex');
Route::get('/xujjatBerilganJoyi/add', [XujjatBerilganJoyiController::class, 'add'])->name('xujjatBerilganJoyiAdd');
Route::post('/xujjatBerilganJoyi/create', [XujjatBerilganJoyiController::class, 'create'])->name('xujjatBerilganJoyiCreate');
Route::get('/xujjatBerilganJoyi/edit/{id}', [XujjatBerilganJoyiController::class, 'edit'])->name('xujjatBerilganJoyiEdit');
Route::post('/xujjatBerilganJoyi/update/{id}', [XujjatBerilganJoyiController::class, 'update'])->name('xujjatBerilganJoyiUpdate');
Route::delete('/xujjatBerilganJoyi/delete/{id}', [XujjatBerilganJoyiController::class, 'destroy'])->name('xujjatBerilganJoyiDestroy');

// ruxsatnomaTurlari
Route::get('/ruxsatnomaTurlari', [RuxsatnomaTuriController::class, 'index'])->name('ruxsatnomaTuriIndex');
Route::get('/ruxsatnomaTuri/add', [RuxsatnomaTuriController::class, 'add'])->name('ruxsatnomaTuriAdd');
Route::post('/ruxsatnomaTuri/create', [RuxsatnomaTuriController::class, 'create'])->name('ruxsatnomaTuriCreate');
Route::get('/ruxsatnomaTuri/edit/{id}', [RuxsatnomaTuriController::class, 'edit'])->name('ruxsatnomaTuriEdit');
Route::post('/ruxsatnomaTuri/update/{id}', [RuxsatnomaTuriController::class, 'update'])->name('ruxsatnomaTuriUpdate');
Route::delete('/ruxsatnomaTuri/delete/{id}', [RuxsatnomaTuriController::class, 'destroy'])->name('ruxsatnomaTuriDestroy');

// ruxsatnoma berilgan ish turi
Route::get('/ruxsatnomaBerilganIshTurlari', [RuxsatnomaBerilganIshTuriController::class, 'index'])->name('ruxsatnomaBerilganIshTuriIndex');
Route::get('/ruxsatnomaBerilganIshTuri/add', [RuxsatnomaBerilganIshTuriController::class, 'add'])->name('ruxsatnomaBerilganIshTuriAdd');
Route::post('/ruxsatnomaBerilganIshTuri/create', [RuxsatnomaBerilganIshTuriController::class, 'create'])->name('ruxsatnomaBerilganIshTuriCreate');
Route::get('/ruxsatnomaBerilganIshTuri/edit/{id}', [RuxsatnomaBerilganIshTuriController::class, 'edit'])->name('ruxsatnomaBerilganIshTuriEdit');
Route::post('/ruxsatnomaBerilganIshTuri/update/{id}', [RuxsatnomaBerilganIshTuriController::class, 'update'])->name('ruxsatnomaBerilganIshTuriUpdate');
Route::delete('/ruxsatnomaBerilganIshTuri/delete/{id}', [RuxsatnomaBerilganIshTuriController::class, 'destroy'])->name('ruxsatnomaBerilganIshTuriDestroy');

// ruxsatnoma Kim Tamonidan
Route::get('/ruxsatnomaKimTamonidanlari', [RuxsatnomaKimTamonidanController::class, 'index'])->name('ruxsatnomaKimTamonidanIndex');
Route::get('/ruxsatnomaKimTamonidani/add', [RuxsatnomaKimTamonidanController::class, 'add'])->name('ruxsatnomaKimTamonidanAdd');
Route::post('/ruxsatnomaKimTamonidani/create', [RuxsatnomaKimTamonidanController::class, 'create'])->name('ruxsatnomaKimTamonidanCreate');
Route::get('/ruxsatnomaKimTamonidani/edit/{id}', [RuxsatnomaKimTamonidanController::class, 'edit'])->name('ruxsatnomaKimTamonidanEdit');
Route::post('/ruxsatnomaKimTamonidani/update/{id}', [RuxsatnomaKimTamonidanController::class, 'update'])->name('ruxsatnomaKimTamonidanUpdate');
Route::delete('/ruxsatnomaKimTamonidani/delete/{id}', [RuxsatnomaKimTamonidanController::class, 'destroy'])->name('ruxsatnomaKimTamonidanDestroy');

Route::get('/generate/doc', [FileController::class, 'index'])->name('generate_doc');

// Orders buyurtmalar
Route::get('/ariza', [OrderController::class, 'index'])->name('orders.index');
Route::get('/ariza/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/ariza/{id}/approve', [OrderController::class, 'approve'])->name('order.approve.item');
Route::post('/ariza/{id}/reject', [OrderController::class, 'reject'])->name('order.reject.item');
Route::get('/ariza/arxiv/{id}', [OrderController::class, 'arxiv'])->name('orderArxiv');


// Order Atkaz 
Route::get('/orderAtkaz', [OrderAtkazController::class, 'index'])->name('orderAtkazIndex');
Route::get('/orderAtkaz/add', [OrderAtkazController::class, 'add'])->name('orderAtkazAdd');
Route::post('/orderAtkaz/create', [OrderAtkazController::class, 'create'])->name('orderAtkazCreate');
Route::get('/orderAtkaz/edit/{id}', [OrderAtkazController::class, 'edit'])->name('orderAtkazEdit');
Route::post('/orderAtkaz/update/{id}', [OrderAtkazController::class, 'update'])->name('orderAtkazUpdate');
Route::delete('/orderAtkaz/delete/{id}', [OrderAtkazController::class, 'destroy'])->name('orderAtkazDestroy');


// Order Atkaz 
Route::get('shartnoma', [ShartnomaController::class, 'index'])->name('shartnoma.index');
Route::get('shartnoma/grafik/{id}', [ShartnomaController::class, 'grafik'])->name('grafik.show');
Route::get('shartnoma/{id}', [ShartnomaController::class, 'show'])->name('shartnoma.show');
Route::get('shartnoma/{id}/add', [ShartnomaController::class, 'add'])->name('shartnoma.add');
Route::get('/get-client/{unique_code}', [ShartnomaController::class, 'getClientByUniqueCode'])->name('get-client-by-unique-code');
Route::post('/shartnoma/shartnoma_create', [ShartnomaController::class, 'shartnoma_create'])->name('shartnoma_create');
Route::post('/shartnoma/{id}/approve', [ShartnomaController::class, 'approve'])->name('shartnoma.approve.item');
Route::post('/shartnoma/{id}/reject', [ShartnomaController::class, 'reject'])->name('shartnoma.reject.item');


// web.php

Route::get('/fact_payments/create/{shartnoma_id}', [FactPaymentController::class, 'create'])->name('fact_payments.create');
Route::post('/fact_payments', [FactPaymentController::class, 'store'])->name('fact_payments.store');

// clean routes start -----------------------------------------------------------------------------------------------------

Route::get('subyekt/', [SubyektController::class, 'index'])->name('clientIndex');
Route::get('subyekt/{id}', [SubyektController::class, 'show'])->name('clientDetails');
Route::get('subyekt/arxiv/{id}', [SubyektController::class, 'arxiv'])->name('clientArxiv');

Route::post('/create/fizik', [SubyektController::class, 'create_fizik_client'])->name('create_fizik_client');
Route::post('/create/yuridik', [SubyektController::class, 'create_yuridik_client'])->name('create_yuridik_client');

Route::get('subyekt/edit_fizik/{id}', [SubyektController::class, 'edit_fizik'])->name('clientFizikEdit');
Route::get('subyekt/edit_yuridik/{id}', [SubyektController::class, 'edit_yuridik'])->name('clientYuridikEdit');

Route::match(['put', 'post'], 'subyekt/fizik/{id}', [SubyektController::class, 'update_fizik_client'])->name('update_fizik_client');
Route::match(['put', 'post'], 'subyekt/yuridik/{id}', [SubyektController::class, 'update_yuridik_client'])->name('update_yuridik_client');

Route::get('subyekt/add/fizik', [SubyektController::class, 'add_fizik'])->name('clientFizikAdd');
Route::get('subyekt/add/yuridik', [SubyektController::class, 'add_yuridik'])->name('clientYuridikAdd');

Route::delete('subyekt/delete/{id}', [SubyektController::class, 'delete'])->name('clientDestroy');
Route::post('subyekt/toggle-status/{id}', [SubyektController::class, 'toggleclientActivation'])->name('clientActivation');

// obyekt start -----------------------------------------------------------------------------------------------------


Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
Route::get('/monitoring/create', [MonitoringController::class, 'create'])->name('monitoring.create');
Route::post('/monitoring', [MonitoringController::class, 'store'])->name('monitoring.store');
Route::get('/monitoring/{monitoring}', [MonitoringController::class, 'show'])->name('monitoring.show');
Route::get('/monitoring/{id}/edit', [MonitoringController::class, 'edit'])->name('monitoring.edit');
Route::put('/monitoring/{monitoring}', [MonitoringController::class, 'update'])->name('monitoring.update');
Route::delete('/monitoring/{monitoring}', [MonitoringController::class, 'destroy'])->name('monitoring.destroy');

Route::get('shartnoma/{id}/edit', [MonitoringController::class, 'editShartnoma'])->name('shartnoma.edit');
Route::put('shartnoma/{id}', [MonitoringController::class, 'updateShartnoma'])->name('shartnoma.update');

Route::get('apz/{id}/edit', [MonitoringController::class, 'editApz'])->name('apz.edit');
Route::put('apz/{id}', [MonitoringController::class, 'updateApz'])->name('apz.update');

Route::get('kengash/{id}/edit', [MonitoringController::class, 'editKengash'])->name('kengash.edit');
Route::put('kengash/{id}', [MonitoringController::class, 'updateKengash'])->name('kengash.update');

Route::get('expertiza/{id}/edit', [MonitoringController::class, 'editExpertiza'])->name('expertiza.edit');
Route::put('expertiza/{id}', [MonitoringController::class, 'updateExpertiza'])->name('expertiza.update');


// Apz routes
Route::post('apz/store', [MonitoringController::class, 'art_store'])->name('apz.store');

// Kengash routes
Route::post('kengash/store', [MonitoringController::class, 'kengash_store'])->name('kengash.store');

// Expertiza routes
Route::post('expertiza/store', [MonitoringController::class, 'expertiza_store'])->name('expertiza.store');

// ДАҚН (ГАСН) routes
Route::post('dakn/store', [MonitoringController::class, 'dakn_gasn_inspection_store'])->name('dakn.store');


Route::get('excel/index', [ExcelController::class, 'index'])->name('excel.excel_Index');
Route::get('excel/import-export', [ExcelController::class, 'index_imp_exp'])->name('excel.import-export');
Route::post('excel/import', [ExcelController::class, 'import'])->name('excel.import');
Route::get('excel/export', [ExcelController::class, 'export'])->name('excel.export');


// custom routes
// Route::get('/', function () {
//     return redirect()->route('aktivs.index');
// });

// Route::resource('aktivs', AktivController::class);
// Import the controller at the top

// Define routes individually

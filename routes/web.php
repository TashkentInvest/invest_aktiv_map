<?php

use App\Http\Controllers\AddNewUsersController;
use App\Http\Controllers\AktivController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\StreetController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\SubStreetController;
use App\Http\Controllers\Blade\HomeController;
use App\Http\Controllers\Blade\UserController;
use App\Http\Controllers\Blade\RegionController;
use App\Http\Controllers\ConstructionController;
use App\Http\Controllers\Blade\DistrictController;
use App\Http\Controllers\CommentController;


// Default laravel auth routes
Auth::routes(['register' => false]);

// Welcome page
Route::get('/', function () {
    return view('welcome');
});



Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/statistics', [HomeController::class, 'statistics'])->name('statistics.show');
Route::get('/statistics', [HomeController::class, 'statistics'])->name('statistics.index');

// Web pages
Route::group(['middleware' => ['auth', 'checkUserRole']], function () {

    Route::get('aktivs', [AktivController::class, 'index'])->name('aktivs.index');
    Route::get('aktivs/create', [AktivController::class, 'create'])->name('aktivs.create');
    Route::post('aktivs', [AktivController::class, 'store'])->name('aktivs.store');
    Route::get('aktivs/{aktiv}', [AktivController::class, 'show'])->name('aktivs.show');
    Route::get('aktivs/{aktiv}/edit', [AktivController::class, 'edit'])->name('aktivs.edit');
    Route::put('aktivs/{aktiv}', [AktivController::class, 'update'])->name('aktivs.update');
    Route::delete('aktivs/{aktiv}', [AktivController::class, 'destroy'])->name('aktivs.destroy');
    Route::get('aktiv/userlar', [AktivController::class, 'userAktivCounts'])->name('aktivs.userAktivCounts');
    Route::get('aktiv/tumans', [AktivController::class, 'userTumanlarCounts'])->name('aktivs.userTumanlarCounts');


    Route::get('aktiv/kadastr/tumanlar', [AktivController::class, 'kadastrTumanlarCounts'])->name('aktivs.kadastrTumanlarCounts');
    Route::get('/aktiv/kadastr_borlar', [AktivController::class, 'kadastrBorlar'])->name('aktivs.kadastrBorlar');
    Route::get('/aktiv/kadastr/{district_id}', [AktivController::class, 'kadastrByDistrict'])->name('aktivs.kadastrByDistrict');
    Route::get('/aktiv/get_kadastr_by_district', [AktivController::class, 'getKadastrByDistrict']);

    Route::post('/aktivs/export', [AktivController::class, 'export'])->name('aktivs.export');
    Route::post('/aktivs/status_invest_moderator', [AktivController::class, 'status_invest_moderator'])->name('aktivs.status_invest_moderator');


    Route::get('/kadastr', [AktivController::class, 'kadastr_index'])->name('aktivs.kadastr_index');
    Route::post('/aktivs/kadastr', [AktivController::class, 'kadastr'])->name('aktivs.kadastr');
    Route::post('/aktivs/{id}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::get('/my-map', [AktivController::class, 'myMap'])->name('aktivs.myMap');

    Route::get('/getDistrict', [AktivController::class, 'getDistrict'])->name('getDistrict');
    Route::get('/getStreets', [AktivController::class, 'getStreets'])->name('getStreets');
    Route::get('/getSubStreets', [AktivController::class, 'getSubStreets'])->name('getSubStreets');
    Route::post('/create/streets', [AktivController::class, 'createStreet'])->name('create.streets');
    Route::post('/create/substreets', [AktivController::class, 'createSubStreet'])->name('create.substreets');

    Route::get('/custom/get-districts', [AktivController::class, 'getObDistricts'])->name('get.Obdistricts');
    Route::get('/custom/get-streets', [AktivController::class, 'getObStreets'])->name('get.Obstreets');
    Route::get('/custom/get-substreets', [AktivController::class, 'getObSubstreets'])->name('get.Obsubstreets');

    Route::get('/optimize-cache', [HomeController::class, 'optimize'])->name('optimize.command');


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



// Regions
Route::get('/regions', [RegionController::class, 'index'])->name('regionIndex');
Route::get('/region/add', [RegionController::class, 'add'])->name('regionAdd');
Route::post('/region/create', [RegionController::class, 'create'])->name('regionCreate');
Route::get('/region/edit/{id}', [RegionController::class, 'edit'])->name('regionEdit');
Route::post('/region/update/{id}', [RegionController::class, 'update'])->name('regionUpdate');
Route::delete('/region/delete/{id}', [RegionController::class, 'destroy'])->name('regionDestroy');
// District
Route::get('/districts', [DistrictController::class, 'index'])->name('districtIndex');
Route::get('/district/add', [DistrictController::class, 'add'])->name('districtAdd');
Route::post('/district/create', [DistrictController::class, 'create'])->name('districtCreate');
Route::get('/district/edit/{id}', [DistrictController::class, 'edit'])->name('districtEdit');
Route::post('/district/update/{id}', [DistrictController::class, 'update'])->name('districtUpdate');
Route::delete('/district/delete/{id}', [DistrictController::class, 'destroy'])->name('districtDestroy');
Route::get('/get-districts/{region_id}', [DistrictController::class, 'getDistrict'])->name('get.districts');
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




// custom routes
// Route::get('/', function () {
//     return redirect()->route('aktivs.index');
// });

// Route::resource('aktivs', AktivController::class);
// Import the controller at the top

// Define routes individually


Route::post('/import-users', [AddNewUsersController::class, 'importUsers'])->name('import.users');

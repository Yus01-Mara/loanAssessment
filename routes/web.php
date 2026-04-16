<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ElementController;
use App\Http\Controllers\Admin\SubElementController;
use App\Http\Controllers\Admin\RatingController;

use App\Http\Controllers\Penilaian\PenilaianController;

Route::get('/penilaian/{id}', [PenilaianController::class, 'create']);


/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/admin/elements');
});

Route::get('/loan/apps', function () {
    $apps = \App\Models\LoanApplication::all();
    return view('loan.index', compact('apps'));
});
/*
|--------------------------------------------------------------------------
| ADMIN 5C SETTING
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    /*
    =========================
    5C ELEMENT
    =========================
    */
    Route::resource('elements', ElementController::class);

    /*
    =========================
    SUB ELEMENT
    =========================
    */
    Route::resource('sub-elements', SubElementController::class);

    /*
    =========================
    RATING SCALE
    =========================
    */
    Route::resource('ratings', RatingController::class);

    /*
    =========================
    INLINE AJAX (NO RELOAD)
    =========================
    */

    // ----- ELEMENT -----
    Route::post('elements/update-inline', [ElementController::class, 'updateInline'])
        ->name('elements.updateInline');

    // ----- SUB ELEMENT -----
    Route::post('sub-elements/update-inline', [SubElementController::class, 'updateInline'])
        ->name('sub.updateInline');

    Route::post('sub-elements/add-inline', [SubElementController::class, 'addInline'])
        ->name('sub.addInline');

    // ----- RATING -----
    Route::post('ratings/update-inline', [RatingController::class, 'updateInline'])
        ->name('rating.updateInline');

    Route::post('ratings/add-inline', [RatingController::class, 'addInline'])
        ->name('rating.addInline');

});


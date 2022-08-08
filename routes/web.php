<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/






Route::middleware(['auth'])->group(function () {

      /* ==================
     *    ===============
     *   || Home Routes ||
     *    ===============
     * ====================
     */
    
    
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');






    /* ======================
     *    ================
     *   || Units Routes ||
     *    ================
     * ======================
     */
    
    
    Route::get('/units', [\App\Http\Controllers\UnitController::class , 'showAllUnits']);
    Route::get('/units/district/{dis}', [\App\Http\Controllers\UnitController::class , 'showAllDistUnits'])->name('showAllDistUnits');

    
    Route::get('/addunit', [\App\Http\Controllers\UnitController::class , 'addUnit']);
    Route::post('/unit/add', [\App\Http\Controllers\UnitController::class , 'addnewUnit'])->name('addnew');
    Route::get('addnew/unit/in/{did}', [\App\Http\Controllers\UnitController::class , 'addnewUnitBack'])->name('addnewUnitBack');
    Route::post('/photo', [\App\Http\Controllers\UnitController::class , 'upload_addPhoto'])->name('upload.uploadfile');

    Route::post('/unit/update', [\App\Http\Controllers\UnitController::class , 'updateUnit'])->name('update');
    Route::get('/unit/{uid}', [\App\Http\Controllers\UnitController::class , 'updateUnit_view'])->name('updateview');
    
    Route::post('/unit/delete/{uid}', [\App\Http\Controllers\UnitController::class , 'deleteUnit'])->name('deleteunit');
    



    /* =======================
     *    =================
     *   || Photos Routes ||
     *    =================
     * =======================
     */
    
    Route::post('/unit/photos/change', [\App\Http\Controllers\UnitController::class , 'changePhoto'])->name('changePhoto');
    
    Route::post('/unit/photos/update', [\App\Http\Controllers\UnitController::class , 'updateunitPhoto'])->name('addnewPhotos');
    
    Route::get('/unit/photo/{uid}', [\App\Http\Controllers\UnitController::class , 'updatePhoto_view'])->name('updatephotoview');
    Route::get('/unit/{uid}/photos/add', [\App\Http\Controllers\UnitController::class , 'updateunitPhotoView'])->name('updateunitPhotoView');
    
    Route::post('/unit/photos/delete', [\App\Http\Controllers\UnitController::class , 'deletePhoto'])->name('deletePhoto');




    
    /* =========================
     *    ==================
     *   || Regions Routes ||
     *    ==================
     * =========================
     */
    
    Route::get('/regions', [App\Http\Controllers\LocationController::class, 'allRegions']);
    
    Route::get('/regions/add', [App\Http\Controllers\LocationController::class, 'addregion_view']);
    Route::post('/regions/add/new', [App\Http\Controllers\LocationController::class, 'addregion'])->name('addregion');
    
    Route::post('/region/update', [\App\Http\Controllers\LocationController::class , 'updateregionData'])->name('updateregion');
    Route::get('/region/{rid}', [\App\Http\Controllers\LocationController::class , 'updateRegion_view'])->name('updateregionview');


    

    /* ========================
     *    =================
     *   || Cities Routes ||
     *    =================
     * ========================
     */
    
    Route::get('/cities', [App\Http\Controllers\LocationController::class, 'allCities']);
    Route::get('/cities/region/{rid}', [App\Http\Controllers\LocationController::class, 'allRegionCities'])->name('allRegionCities');

    
    Route::post('/city/regionselect', [App\Http\Controllers\LocationController::class, 'addcity_view'])->name('addcity_select');
    Route::get('/addnewcity/region/{rid}', [App\Http\Controllers\LocationController::class, 'addcity_viewBack'])->name('addcity_viewBack');
    Route::post('/city/add', [App\Http\Controllers\LocationController::class, 'addcity'])->name('addcity');
    
    Route::get('/city/{cid}', [\App\Http\Controllers\LocationController::class , 'updateCity_view'])->name('updatecityview');
    Route::post('/city/update', [\App\Http\Controllers\LocationController::class , 'updatecityData'])->name('updatecity');




    /* ==========================
     *    ====================
     *   || Districts Routes ||
     *    ====================
     * ==========================
     */
    
    Route::get('/districts', [App\Http\Controllers\LocationController::class, 'allDistricts']);
    Route::get('/districts/city/{cid}', [App\Http\Controllers\LocationController::class, 'allCityDistricts'])->name('allCityDistricts');

    Route::get('/district/locationselect', [App\Http\Controllers\LocationController::class, 'addDist'])->name('addDist_location_select');
    Route::post('/district/cityselect', [App\Http\Controllers\LocationController::class, 'addDist_view'])->name('addDist_select');
    Route::get('/addnewdist/city/{cid}', [App\Http\Controllers\LocationController::class, 'addDist_viewBack'])->name('addDist_viewBack');
    Route::post('/dist/add', [App\Http\Controllers\LocationController::class, 'add_dist'])->name('adddist');
    
    Route::get('/dist/{did}', [\App\Http\Controllers\LocationController::class , 'updateDist_view'])->name('updateDistview');
    Route::post('/dist/update', [\App\Http\Controllers\LocationController::class , 'updatedistData'])->name('updatedist');




  /* ============================
     *    ===================
     *   || Website Routes  ||
     *    ===================
     * ==========================
     */

    Route::get('/web/counters', [App\Http\Controllers\WebsiteController::class, 'allCounters']);
    Route::get('/web/hero-cards', [App\Http\Controllers\WebsiteController::class, 'allCards']);
    Route::get('/web/explore', [App\Http\Controllers\WebsiteController::class, 'allExploreCards']);
    Route::get('/web/clients', [App\Http\Controllers\WebsiteController::class, 'allClients']);
    
    
    Route::get('/web/counters/{countid}', [App\Http\Controllers\WebsiteController::class, 'updateCountersView'])->name('updateCountersView');
    Route::get('/web/hero-cards/{cardid}', [App\Http\Controllers\WebsiteController::class, 'updateHeroCardsView'])->name('updateHeroCardsView');
    Route::get('/web/explore/{cardid}', [App\Http\Controllers\WebsiteController::class, 'updateExploreView'])->name('updateExploreView');


    Route::post('/web/counters/update', [App\Http\Controllers\WebsiteController::class, 'updateCounters'])->name('updateCounters');
    Route::post('/web/hero-cards/update', [App\Http\Controllers\WebsiteController::class, 'updateHeroCards'])->name('updateHeroCards');
    Route::post('/web/explore/update', [App\Http\Controllers\WebsiteController::class, 'updateExplore'])->name('updateExplore');
    Route::post('/web/clients/update', [App\Http\Controllers\WebsiteController::class, 'updateClients'])->name('updateClients');


    Route::get('/web/clients/add', [App\Http\Controllers\WebsiteController::class, 'addClientView'])->name('addClientView');
    Route::post('/web/clients/addnew', [App\Http\Controllers\WebsiteController::class, 'addClient'])->name('addClient');
   






    /* ==========================
     *    ===================
     *   || Contacts Routes ||
     *    ===================
     * ==========================
     */
    
    Route::get('/contacts', [\App\Http\Controllers\ContactUsController::class , 'showContacts']);



});


Auth::routes();


<?php

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

Route::get('/', function () { return view('welcome');});
Route::get('/login', [ 'as' => 'login', 'uses' => 'AdminLoginController@getLogin']);
Route::post('/login', 'AdminLoginController@doLogin');
Route::get('/logout', 'AdminLoginController@doLogout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'AdminHomeController@getHome');

    /** ENTREPRENEURS  */
    Route::get('/entrepreneurs', 'AdminEntrepreneurController@getEntrepreneurs');
    Route::get('/entrepreneur/profile/create', 'AdminEntrepreneurController@getCreateProfile');
    Route::get('/entrepreneur/profile/{id}', 'AdminEntrepreneurController@getProfile');
    Route::post('/entrepreneur/profile/create', 'AdminEntrepreneurController@createProfile');
    Route::post('/entrepreneur/profile/update/{id}', 'AdminEntrepreneurController@updateProfile');
    Route::post('/entrepreneur/profile/delete/{id}', 'AdminEntrepreneurController@deleteProfile');


    /** ENQUETES  */
    Route::get('/surveys', function () { return view('surveys');});
    Route::post('/surveys/export/all', 'AdminSurveyController@exportAllSurvey');
    Route::post('/surveys/export/entrepreneur', 'AdminSurveyController@exportEntrepreneurSurvey');
    Route::post('/surveys/export/prospect', 'AdminSurveyController@exportProspectSurvey');
    
    /** KPI  */
    /* 
    Route::get('/kpi', function () { return redirect('/kpi/prospection');});
    Route::get('/kpi/prospection', 'AdminKpiController@getProspectionKpi');
    Route::get('/kpi/prospection/data/{period?}', 'AdminKpiController@getProspectionKpiData');
     */
    
    /** VENTES  */
    Route::get('/sales', function () { return view('sales');});
    Route::post('/sales/export/all', 'AdminSalesController@exportAllSales');
    Route::post('/sales/export/entrepreneur', 'AdminSalesController@exportEntrepreneurSales');
    Route::post('/sales/export/provider', 'AdminSalesController@exportProviderSales');

    /** PRODIITS/SERVICES  */
    Route::get('/products', 'AdminProductController@getProducts');
    Route::post('/product/update/{id}', 'AdminProductController@productUpdate');
    Route::post('/product/create', 'AdminProductController@productCreate');
    Route::post('/product/delete/{id}', 'AdminProductController@productDelete');
});
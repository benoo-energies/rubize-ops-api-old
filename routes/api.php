<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::get('/', function () {return view('welcome');});
//Route::get('test', 'CustomersController@testTagpay');


Route::post('entrepreneur/login', 'EntrepreneurController@entrepreneurLogin');

// Route GET Liste des types de services
Route::get('services/types', 'ServicesController@getServiceTypes');
Route::get('services/types/{entrepreneurBenooId}', 'ServicesController@getServiceTypesEnt');
// Route GET Liste des services par type
Route::get('services/{typeId}', 'ServicesController@getServiceByType');

Route::get('entrepreneur/check/{entrepreneurTel}', 'EntrepreneurController@checkEntrepreneurLogin');
Route::get('entrepreneur/history/{entrepreneurId}', 'EntrepreneurController@getEntrepreneurHistory');

// Route POST de création de compte client
Route::post('customer/{entrepreneurId}/create', 'CustomersController@createCustomer');
// Route de GET récupération d'un compte client
Route::get('customer/{entrepreneurId}/{customerNum}', 'CustomersController@getCustomerProfile');


// Route POST d'enregistrement des ventes
Route::post('order/{entrepreneurId}/create', 'OrderController@saveOrder');

// Page POST d'enregistrement des enquêtes
Route::post('survey-prospect/create', 'SurveyController@saveSurveyProspect');
Route::post('survey/{entrepreneurId}/create', 'SurveyController@saveSurvey');
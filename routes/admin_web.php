<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Models\User;

$router->group(['namespace' => 'Web'], function ($router) {
  $router->group(['prefix' => 'auth'], function ($router) {
    $router->post('/', 'AuthController@store');
    $router->delete('/', 'AuthController@destroy');
  });

  $router->group(['middleware' => 'auth:api', 'prefix' => 'auth'], function ($router) {
    $router->get('/', 'AuthController@show');
    $router->put('/', 'AuthController@update');
    $router->post('/change-password', 'AuthController@change_password');
    $router->get('/roles', 'AuthController@roles');
  });

  $router->group(['middleware' => 'auth:api', 'prefix' => 'users'], function ($router) {
    $router->get('/', 'UserController@index');
    $router->post('/', 'UserController@store');
    $router->put('/profile', 'UserController@profile');
    $router->put('/photo', 'UserController@photo');
    $router->get('/{id:[0-9]+}', 'UserController@show');
    $router->put('/{id:[0-9]+}', 'UserController@update');
    $router->patch('/{id:[0-9]+}', 'UserController@update');
    $router->delete('/{id:[0-9]+}', 'UserController@destroy');
  });

  $router->group(['middleware' => 'auth:api', 'prefix' => 'user-contract'], function ($router) {
    $router->get('/', 'UserContractController@index');
    $router->post('/', 'UserContractController@store');
    $router->get('/{id:[0-9]+}', 'UserContractController@show');
    $router->put('/{id:[0-9]+}', 'UserContractController@update');
    $router->patch('/{id:[0-9]+}', 'UserContractController@update');
    $router->delete('/{id:[0-9]+}', 'UserContractController@destroy');
  });
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'upload'], function ($router) {
  $router->post('/', 'UploadController@store');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'merchant'], function ($router) {
  $router->get('/', 'MerchantController@index');
  $router->post('/', 'MerchantController@store');
  $router->get('/{id:[0-9]+}', 'MerchantController@show');
  $router->put('/{id:[0-9]+}', 'MerchantController@update');
  $router->patch('/{id:[0-9]+}', 'MerchantController@update');
  $router->delete('/{id:[0-9]+}', 'MerchantController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'chiller'], function ($router) {
  $router->get('/', 'ChillerController@index');
  $router->post('/', 'ChillerController@store');
  $router->get('/{id:[0-9]+}', 'ChillerController@show');
  $router->put('/{id:[0-9]+}', 'ChillerController@update');
  $router->patch('/{id:[0-9]+}', 'ChillerController@update');
  $router->delete('/{id:[0-9]+}', 'ChillerController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'survey'], function ($router) {
  $router->get('/', 'SurveyController@index');
  $router->post('/', 'SurveyController@store');
  $router->get('/{id:[0-9]+}', 'SurveyController@show');
  $router->get('/chiller', 'SurveyController@detailChiller');
  $router->get('/products', 'SurveyController@detailProducts');
  $router->get('/reports', 'SurveyController@reports');
  $router->get('/export', 'SurveyController@export');
  $router->put('/{id:[0-9]+}/closed', 'SurveyController@closed');
  $router->put('/{id:[0-9]+}', 'SurveyController@update');
  $router->patch('/{id:[0-9]+}', 'SurveyController@update');
  $router->delete('/{id:[0-9]+}', 'SurveyController@destroy');

  $router->get('/schedule', 'SurveyScheduleController@index');
  $router->post('/schedule', 'SurveyScheduleController@store');
  $router->get('/schedule/{id:[0-9]+}', 'SurveyScheduleController@show');
  $router->put('/schedule/{id:[0-9]+}', 'SurveyScheduleController@update');
  $router->patch('/schedule/{id:[0-9]+}', 'SurveyScheduleController@update');
  $router->delete('/schedule/{id:[0-9]+}', 'SurveyScheduleController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'regulation'], function ($router) {
  $router->get('/', 'RegulationController@index');
  $router->post('/', 'RegulationController@store');
  $router->get('/{id:[0-9]+}', 'RegulationController@show');
  $router->put('/{id:[0-9]+}', 'RegulationController@update');
  $router->patch('/{id:[0-9]+}', 'RegulationController@update');
  $router->delete('/{id:[0-9]+}', 'RegulationController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'supplier'], function ($router) {
  $router->get('/', 'SupplierController@index');
  $router->post('/', 'SupplierController@store');
  $router->get('/{id:[0-9]+}', 'SupplierController@show');
  $router->put('/{id:[0-9]+}', 'SupplierController@update');
  $router->patch('/{id:[0-9]+}', 'SupplierController@update');
  $router->delete('/{id:[0-9]+}', 'SupplierController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'product'], function ($router) {
  $router->get('/', 'ProductController@index');
  $router->post('/', 'ProductController@store');
  $router->get('/{id:[0-9]+}', 'ProductController@show');
  $router->put('/{id:[0-9]+}', 'ProductController@update');
  $router->patch('/{id:[0-9]+}', 'ProductController@update');
  $router->delete('/{id:[0-9]+}', 'ProductController@destroy');

  // category
  $router->get('/category', 'ProductCategoryController@index');
  $router->post('/category', 'ProductCategoryController@store');
  $router->get('/category/{id:[0-9]+}', 'ProductCategoryController@show');
  $router->put('/category/{id:[0-9]+}', 'ProductCategoryController@update');
  $router->patch('/category/{id:[0-9]+}', 'ProductCategoryController@update');
  $router->delete('/category/{id:[0-9]+}', 'ProductCategoryController@destroy');

  // chiller
  $router->get('/chiller', 'ProductChillerController@index');
  $router->post('/chiller', 'ProductChillerController@store');
  $router->get('/chiller/{id:[0-9]+}', 'ProductChillerController@show');
  $router->put('/chiller/{id:[0-9]+}/restore', 'ProductChillerController@restore');
  $router->put('/chiller/{id:[0-9]+}', 'ProductChillerController@update');
  $router->patch('/chiller/{id:[0-9]+}', 'ProductChillerController@update');
  $router->delete('/chiller/{id:[0-9]+}', 'ProductChillerController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'location'], function ($router) {
  $router->get('/', 'LocationController@index');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'log-book'], function ($router) {
  $router->get('/', 'LogBookController@index');
  $router->post('/', 'LogBookController@store');
  $router->get('/{id:[0-9]+}', 'LogBookController@show');
  $router->put('/{id:[0-9]+}', 'LogBookController@update');
  $router->patch('/{id:[0-9]+}', 'LogBookController@update');
  $router->delete('/{id:[0-9]+}', 'LogBookController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'user-archive'], function ($router) {
  $router->get('/', 'UserArchiveController@index');
  $router->post('/', 'UserArchiveController@store');
  $router->get('/{id:[0-9]+}', 'UserArchiveController@show');
  $router->put('/{id:[0-9]+}', 'UserArchiveController@update');
  $router->patch('/{id:[0-9]+}', 'UserArchiveController@update');
  $router->delete('/{id:[0-9]+}', 'UserArchiveController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'announcement'], function ($router) {
  $router->get('/', 'AnnouncementController@index');
  $router->post('/', 'AnnouncementController@store');
  $router->get('/{id:[0-9]+}', 'AnnouncementController@show');
  $router->put('/{id:[0-9]+}', 'AnnouncementController@update');
  $router->patch('/{id:[0-9]+}', 'AnnouncementController@update');
  $router->delete('/{id:[0-9]+}', 'AnnouncementController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'department'], function ($router) {
  $router->get('/', 'DepartmentController@index');
  $router->post('/', 'DepartmentController@store');
  $router->get('/{id:[0-9]+}', 'DepartmentController@show');
  $router->put('/{id:[0-9]+}', 'DepartmentController@update');
  $router->patch('/{id:[0-9]+}', 'DepartmentController@update');
  $router->delete('/{id:[0-9]+}', 'DepartmentController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'area'], function ($router) {
  $router->get('/', 'AreaController@index');
  $router->post('/', 'AreaController@store');
  $router->get('/{id:[0-9]+}', 'AreaController@show');
  $router->put('/{id:[0-9]+}', 'AreaController@update');
  $router->patch('/{id:[0-9]+}', 'AreaController@update');
  $router->delete('/{id:[0-9]+}', 'AreaController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'archive'], function ($router) {
  $router->get('/', 'ArchiveController@index');
  $router->post('/', 'ArchiveController@store');
  $router->get('/{id:[0-9]+}', 'ArchiveController@show');
  $router->put('/{id:[0-9]+}', 'ArchiveController@update');
  $router->patch('/{id:[0-9]+}', 'ArchiveController@update');
  $router->delete('/{id:[0-9]+}', 'ArchiveController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'contract-type'], function ($router) {
  $router->get('/', 'ContractTypeController@index');
  $router->post('/', 'ContractTypeController@store');
  $router->get('/{id:[0-9]+}', 'ContractTypeController@show');
  $router->put('/{id:[0-9]+}', 'ContractTypeController@update');
  $router->patch('/{id:[0-9]+}', 'ContractTypeController@update');
  $router->delete('/{id:[0-9]+}', 'ContractTypeController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'client'], function ($router) {
  $router->get('/', 'ClientController@index');
  $router->post('/', 'ClientController@store');
  $router->get('/{id:[0-9]+}', 'ClientController@show');
  $router->put('/{id:[0-9]+}', 'ClientController@update');
  $router->patch('/{id:[0-9]+}', 'ClientController@update');
  $router->delete('/{id:[0-9]+}', 'ClientController@destroy');
  $router->get('/employee', 'ClientController@employee');
  $router->put('/contract', 'ClientController@contract');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'client-area'], function ($router) {
  $router->get('/', 'ClientAreaController@index');
  $router->post('/', 'ClientAreaController@store');
  $router->get('/{id:[0-9]+}', 'ClientAreaController@show');
  $router->put('/{id:[0-9]+}', 'ClientAreaController@update');
  $router->patch('/{id:[0-9]+}', 'ClientAreaController@update');
  $router->delete('/{id:[0-9]+}', 'ClientAreaController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'client-location'], function ($router) {
  $router->get('/', 'ClientLocationController@index');
  $router->post('/', 'ClientLocationController@store');
  $router->get('/{id:[0-9]+}', 'ClientLocationController@show');
  $router->put('/{id:[0-9]+}', 'ClientLocationController@update');
  $router->patch('/{id:[0-9]+}', 'ClientLocationController@update');
  $router->delete('/{id:[0-9]+}', 'ClientLocationController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'client-regulation'], function ($router) {
  $router->get('/', 'ClientRegulationController@index');
  $router->post('/', 'ClientRegulationController@store');
  $router->get('/{id:[0-9]+}', 'ClientRegulationController@show');
  $router->put('/{id:[0-9]+}', 'ClientRegulationController@update');
  $router->patch('/{id:[0-9]+}', 'ClientRegulationController@update');
  $router->delete('/{id:[0-9]+}', 'ClientRegulationController@destroy');
});

// activity log
$router->group(['prefix' => 'activity'], function ($router) {

  // Dashboards
  $router->get('/', 'ActivityLoggerController@showAccessLog');
  $router->get('/cleared', 'ActivityLoggerController@showClearedActivityLog');

  // Drill Downs
  $router->get('/log/{id}', 'ActivityLoggerController@showAccessLogEntry');
  $router->get('/cleared/log/{id}', 'ActivityLoggerController@showClearedAccessLogEntry');

  // Forms
  $router->delete('/clear-activity', 'ActivityLoggerController@clearActivityLog');
  $router->delete('/destroy-activity', 'ActivityLoggerController@destroyActivityLog');
  $router->post('/restore-log', 'ActivityLoggerController@restoreClearedActivityLog');
});

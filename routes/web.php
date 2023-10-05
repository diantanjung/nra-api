<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    $data = [
        'name' => config('app.name'),
        'version' => config('app.version'),
        'framework' => $router->app->version(),
        'environment' => config('app.env'),
        'debug_mode' => config('app.debug'),
        'timestamp' => Carbon::now()->toDateTimeString(),
        'timezone' => config('app.timezone'),
    ];

    return response()->json($data, Response::HTTP_OK);
});

$router->get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

$router->get('/woowa', 'TestController@woowa');

$router->get('/about', function () use ($router) {
    $data = [
        'version' => '1.0',
        'name' => 'NRA - Natari Remote Attendance',
        'latest_update' => '2022-10-10'
    ];

    return responseSuccess($data);
});

$router->group(['prefix' => 'auth'], function ($router) {
    $router->post('/', 'AuthController@store');
    $router->post('/forgot-password', 'AuthController@forgot_password');
    $router->post('/verify-device', 'AuthController@verify_device');
    $router->post('/reset-password', 'AuthController@reset_password');
    $router->post('/validate-otp', 'AuthController@validate_otp');
    $router->get('/reset-otp', 'AuthController@reset_otp');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'auth'], function ($router) {
    $router->get('/', 'AuthController@show');
    $router->put('/', 'AuthController@update');
    $router->delete('/', 'AuthController@destroy');
    $router->post('/change-password', 'AuthController@change_password');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'users'], function ($router) {
    $router->get('/', 'UserController@index');
    $router->get('/activity', 'UserController@activity');
    $router->post('/', 'UserController@store');
    $router->put('/profile', 'UserController@profile');
    $router->put('/photo', 'UserController@photo');
    $router->get('/{id:[0-9]+}', 'UserController@show');
    $router->put('/{id:[0-9]+}', 'UserController@update');
    $router->patch('/{id:[0-9]+}', 'UserController@update');
    $router->delete('/{id:[0-9]+}', 'UserController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'user-archive'], function ($router) {
    $router->get('/', 'UserArchiveController@index');
    $router->post('/', 'UserArchiveController@store');
    $router->get('/{id:[0-9]+}', 'UserArchiveController@show');
    $router->put('/{id:[0-9]+}', 'UserArchiveController@update');
    $router->patch('/{id:[0-9]+}', 'UserArchiveController@update');
    $router->delete('/{id:[0-9]+}', 'UserArchiveController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'user-contract'], function ($router) {
    $router->get('/', 'UserContractController@index');
    $router->post('/', 'UserContractController@store');
    $router->get('/{id:[0-9]+}', 'UserContractController@show');
    $router->put('/{id:[0-9]+}', 'UserContractController@update');
    $router->patch('/{id:[0-9]+}', 'UserContractController@update');
    $router->delete('/{id:[0-9]+}', 'UserContractController@destroy');
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
    $router->get('/employee', 'ClientController@employee');
    $router->put('/contract', 'ClientController@contract');
    $router->put('/{id:[0-9]+}', 'ClientController@update');
    $router->patch('/{id:[0-9]+}', 'ClientController@update');
    $router->delete('/{id:[0-9]+}', 'ClientController@destroy');
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

$router->group(['middleware' => 'auth:api', 'prefix' => 'regulation'], function ($router) {
    $router->get('/', 'RegulationController@index');
    $router->post('/', 'RegulationController@store');
    $router->get('/{id:[0-9]+}', 'RegulationController@show');
    $router->put('/{id:[0-9]+}', 'RegulationController@update');
    $router->patch('/{id:[0-9]+}', 'RegulationController@update');
    $router->delete('/{id:[0-9]+}', 'RegulationController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'client-regulation'], function ($router) {
    $router->get('/', 'ClientRegulationController@index');
    $router->post('/', 'ClientRegulationController@store');
    $router->get('/{id:[0-9]+}', 'ClientRegulationController@show');
    $router->put('/{id:[0-9]+}', 'ClientRegulationController@update');
    $router->patch('/{id:[0-9]+}', 'ClientRegulationController@update');
    $router->delete('/{id:[0-9]+}', 'ClientRegulationController@destroy');
});


$router->group(['middleware' => 'auth:api', 'prefix' => 'schedule'], function ($router) {
    $router->get('/', 'ScheduleController@index');
    $router->get('/{day:[0-9]+}', 'ScheduleController@show');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'attendance'], function ($router) {
    $router->get('/', 'AttendanceController@index');
    $router->get('/summary', 'AttendanceController@summary');
    $router->get('/history', 'AttendanceController@history');
    $router->get('/coordinat', 'AttendanceController@coordinat');
    $router->get('/export', 'AttendanceController@export');
    $router->get('/approval', 'AttendanceController@approvals');
    $router->post('/', 'AttendanceController@store');
    $router->put('/late', 'AttendanceController@updateLate');
    $router->put('/approval', 'AttendanceController@updateApproval');
    $router->get('/{id:[0-9]+}', 'AttendanceController@show');
    $router->put('/{id:[0-9]+}', 'AttendanceController@update');
    $router->patch('/{id:[0-9]+}', 'AttendanceController@update');
    $router->delete('/{id:[0-9]+}', 'AttendanceController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'notification'], function ($router) {
    $router->get('/', 'NotificationController@index');
    $router->get('/check', 'NotificationController@check');
    $router->put('/{id:[0-9]+}', 'NotificationController@update');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'upload'], function ($router) {
    $router->post('/', 'UploadController@store');
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
    $router->get('/maintenance', 'SurveyController@maintenance');
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

$router->group(['middleware' => 'auth:api', 'prefix' => 'distributor'], function ($router) {
    $router->get('/', 'DistributorController@index');
    $router->post('/', 'DistributorController@store');
    $router->get('/{id:[0-9]+}', 'DistributorController@show');
    $router->put('/{id:[0-9]+}', 'DistributorController@update');
    $router->patch('/{id:[0-9]+}', 'DistributorController@update');
    $router->delete('/{id:[0-9]+}', 'DistributorController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'events'], function ($router) {
    $router->get('/', 'EventController@index');
    $router->post('/', 'EventController@store');
    $router->get('/{id:[0-9]+}', 'EventController@show');
    $router->put('/{id:[0-9]+}', 'EventController@update');
    $router->patch('/{id:[0-9]+}', 'EventController@update');
    $router->delete('/{id:[0-9]+}', 'EventController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'deposit'], function ($router) {
    $router->get('/', 'DepositController@index');
    $router->post('/', 'DepositController@store');
    $router->get('/{id:[0-9]+}', 'DepositController@show');
    $router->put('/{id:[0-9]+}', 'DepositController@update');
    $router->patch('/{id:[0-9]+}', 'DepositController@update');
    $router->delete('/{id:[0-9]+}', 'DepositController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'sales'], function ($router) {
    $router->get('/', 'SalesController@index');
    $router->post('/', 'SalesController@store');
    $router->get('/{id:[0-9]+}', 'SalesController@show');
    $router->put('/{id:[0-9]+}', 'SalesController@update');
    $router->patch('/{id:[0-9]+}', 'SalesController@update');
    $router->delete('/{id:[0-9]+}', 'SalesController@destroy');
});

$router->group(['middleware' => 'auth:api', 'prefix' => 'procurement'], function ($router) {
    $router->get('/', 'ProcurementController@index');
    $router->get('/products', 'ProcurementController@products');
    $router->post('/', 'ProcurementController@store');
    $router->get('/{id:[0-9]+}', 'ProcurementController@show');
    $router->put('/{id:[0-9]+}', 'ProcurementController@update');
    $router->patch('/{id:[0-9]+}', 'ProcurementController@update');
    $router->delete('/{id:[0-9]+}', 'ProcurementController@destroy');
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


// * WEB
$router->group(['prefix' => 'web'], function ($router) {
    require base_path('routes/admin_web.php');
});

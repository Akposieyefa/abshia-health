<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\HelperController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'api', 'prefix' => 'v1'], function ($router) {

    Route::post('login',[AuthController::class,'login']);

    Route::controller(HelperController ::class)->group(function () {
        Route::get('create-helpers', 'createUserHelper');
        Route::get('lga-helper/{id}', 'getLgaByStateId');
        Route::get('get-all-lga', 'allLga');
    });

    Route::controller(UserController::class)->group(function () { //create new users
        Route::post('onboard-new-users',  'onboardNewUser');
    });

    Route::controller(EmailVerificationController::class)->group(function () {
        Route::post('verify-account',  'verify');
    });

    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::post('password-email',  'send');
        Route::post('password-reset',  'reset');
    });

    Route::group(['middleware' => ['auth:sanctum']], function () { //only authenticated users have access to this routes

        Route::controller(AuthController::class)->group(function () { // Logout and view user profile
            Route::post('logout',  'logout');
            Route::get('user-profile', 'userProfile');
        });

        Route::controller(HelperController ::class)->group(function () { //helper routes
            Route::get('get-dashboard', 'dashBoardCounts');
            Route::get('get-dashboard-hospital', 'getHospitalDashboardMatrix');
        });

        Route::controller(ServiceController::class)->group(function () { // services route
            Route::post('services',  'store');
            Route::get('services',  'index');
            Route::get('services/{id}',  'show');
            Route::patch('services/{id}',  'update');
            Route::delete('services/{id}',  'destroy');
        });

        Route::controller(FeedbackController::class)->group(function () { // feedbacks route
            Route::post('feedbacks',  'store');
            Route::get('feedbacks',  'index');
            Route::get('feedbacks/{id}',  'show');
            Route::delete('feedbacks/{id}',  'destroy');
        });

        Route::controller(CategoryController::class)->group(function () { // categories routes
            Route::post('categories',  'store');
            Route::get('categories',  'index');
            Route::get('categories/{id}',  'show');
            Route::patch('categories/{id}',  'update');
            Route::delete('categories/{id}',  'destroy');
        });

        Route::controller(AppointmentController::class)->group(function () { // appointments routes
            Route::post('appointments',  'store');
            Route::get('appointments',  'index');
            Route::get('appointments/{id}',  'show');
            Route::get('cancel-appointments/{id}',  'declineAppointment');
            Route::patch('appointments/{id}',  'update');
            Route::delete('appointments/{id}',  'destroy');
        });

        Route::controller(UserController::class)->group(function () { // categories routes
            Route::post('create-agents',  'createAgent');
            Route::get('get-agents',  'getAgents');
            Route::delete('delete-account/{id}',  'destroy');
            Route::get('account-details/{id}', 'show');
            Route::patch('account-update-agent/{id}',  'updateAgent');
            Route::patch('account-update-hospital/{id}', 'updateHospital');
            Route::post('create-hospitals',  'createHospital');
            Route::get('get-hospitals',  'getHospitals');
            Route::get('get-onboard-users',  'getAllOnboardedUsers');
        });

    });

});

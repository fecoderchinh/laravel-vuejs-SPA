<?php

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

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', 'Auth\UserController@current');
    Route::get('/users', 'Auth\UserController@index')->middleware(['role:admin', 'role:company']);

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirect');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleCallback')->name('oauth.callback');
});

Route::get('tasks/all', 'TasksController@all');
Route::resource('tasks', 'TasksController');

Route::resource('roles', 'RoleController');

Route::get('/statistics', 'DashboardController@index');

/*
    |--------------------------------------------------------------------------
    | Categories routes
    |--------------------------------------------------------------------------
    |
*/
Route::get('categories/all', 'CategoriesController@all');
Route::resource('categories', 'CategoriesController');
Route::get("/categories/{category}/tasks", "CategoriesController@getTasks")->name("api.categories.tasks");

/*
    |--------------------------------------------------------------------------
    | Tags routes
    |--------------------------------------------------------------------------
*/
Route::get('tags/all', 'TagsController@all');
Route::resource("tags", "TagsController")->except(["store"]);
Route::get("/tags/{tag}/tasks", "TagsController@getTasks")->name("api.tags.tasks");

/*
    |--------------------------------------------------------------------------
    | Comments routes
    |--------------------------------------------------------------------------
*/
//Route::resource("comments", "CommentsController");
Route::get('comments/all', 'CommentsController@all');
Route::get("/comments", "CommentsController@index")->name("api.comments.index");
Route::post("{task}/comments", "CommentsController@store")->name("api.comments.store");
Route::delete("comments/{comment}", "CommentsController@destroy")->name("api.comments.destroy");

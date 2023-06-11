<?php

use App\Models\User;
use App\Scopes\TenantScope;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return [
        'users' => App\Models\User::count(),
        'env' => env('FRONTEND_URL'),
//        'users_by_tenant' => App\Models\User::where('tenant_id', 1)->count(),
    ];
});



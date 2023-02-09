<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GroceryController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/categoryList', [CategoryController::class, 'getAllCategory']);



Route::post('/grocery', [GroceryController::class, 'create']);
Route::get('/grocery/{id}', [GroceryController::class, 'getGroceryById']);
Route::patch('/grocery/{id}', [GroceryController::class, 'updateGrocery']);
Route::delete('/grocery/{id}', [GroceryController::class, 'deleteGrocery']);
Route::get('/groceryList', [GroceryController::class, 'getAllGrocery']);

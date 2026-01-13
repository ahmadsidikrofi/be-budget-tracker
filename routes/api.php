<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json([
        "message" => "Backend are running so fast"
    ]);
});

Route::post('/register', [AuthController::class, "RegisterUser"]);
Route::post('/login', [AuthController::class, "LoginUser"]);
Route::post('/logout', [AuthController::class, "LogoutUser"]);

Route::middleware('auth:sanctum')->group(function () {
    // Category
    Route::get('/categories', [CategoriesController::class, "GetAllCategories"]);
    Route::post('/categories', [CategoriesController::class, "StoreCategory"]);
    Route::get('/categories/{id}', [CategoriesController::class, "GetCategoriesById"]);
    Route::put('/categories/{id}', [CategoriesController::class, "UpdateCategory"]);
    Route::delete('/categories/{id}', [CategoriesController::class, "DeleteCategory"]);
    // Transaction
    Route::get('/transactions', [TransactionController::class, "GetAllTransactions"]);
    Route::post('/transactions', [TransactionController::class, "StoreTransaction"]);
    Route::get('/transactions/{id}', [TransactionController::class, "GetTransactionById"]);
    Route::put('/transactions/{id}', [TransactionController::class, "UpdateTransaction"]);
    Route::delete('/transactions/{id}', [TransactionController::class, "DeleteTransaction"]);

    // Dashboard
    Route::get('/dashboard/recent-transactions', [DashboardController::class, "GetLast5Transactions"]);
    Route::get('/dashboard/summary', [DashboardController::class, "GetSummaryBudget"]);
    Route::get('/reports/spending-by-category', [DashboardController::class, "GetSpendingByCategory"]);
    Route::get('/reports/income-expense-trend', [DashboardController::class, "GetIncomeExpenseTrend"]);
});

Route::get('/migrate', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migrated';
});

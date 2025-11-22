<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ExtraIncomeController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users/create', [ProfileController::class, 'createUser'])->name('users.create');
    Route::post('/users/store', [ProfileController::class, 'storeUser'])->name('users.store');
    Route::get('/users', [ProfileController::class, 'index'])->name('users.index');
    Route::get('/stocks/search', [StockController::class, 'search'])->name('stocks.search');


    Route::resource('medicines', MedicineController::class);

    Route::get('/medicines/search', [MedicineController::class, 'search'])->name('medicines.search');

    Route::resource('purchases', PurchaseController::class);

    Route::resource('sales', SaleController::class);
    // Route::get('/sales', [SaleController::class, 'index']);   // List all sales
    // Route::post('/sales', [SaleController::class, 'storeSale']); // Add new sale
    Route::resource('stocks', StockController::class);
    Route::post('/medicines/store-multiple', [MedicineController::class, 'storeMultiple'])->name('medicines.storeMultiple');
    Route::get('/home', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');
    Route::resource('accounts', App\Http\Controllers\AccountController::class);
    Route::resource('extra_income', ExtraIncomeController::class);
    Route::resource('investors', InvestorController::class);
    Route::resource('investments', InvestmentController::class);
    // Route::resource('users', ProfileController::class);

    Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('reports.index');

    Route::get('/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::post('/sales', [ReportController::class, 'salesReport'])->name('reports.sales.report');

    Route::get('/purchases', [ReportController::class, 'purchases'])->name('reports.purchases');
    Route::post('/purchases', [ReportController::class, 'purchaseReport'])->name('reports.purchases.report');

    Route::get('/stock', [ReportController::class, 'stock'])->name('reports.stock');

    Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('reports.profitLoss');
    Route::post('/profit-loss', [ReportController::class, 'profitLossReport'])->name('reports.profitLoss.report');



    });



});

require __DIR__.'/auth.php';

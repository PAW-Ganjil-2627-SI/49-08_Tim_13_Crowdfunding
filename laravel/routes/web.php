
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\PublicDonorController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AuthController;

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// CAMPAIGN - PUBLIC
// ==========================================

Route::get('/campaigns', [CampaignController::class, 'index'])
    ->name('campaigns.index');

Route::get('/campaigns/{id}', [CampaignController::class, 'show'])
    ->whereNumber('id')
    ->name('campaigns.show');

// ==========================================
// CAMPAIGN - ADMIN
// ==========================================

Route::prefix('admin/campaigns')
    ->name('admin.campaigns.')
    ->controller(CampaignController::class)
    ->group(function () {

        Route::get('/', 'adminIndex')->name('index');

        Route::get('/create', 'create')->name('create');

        Route::post('/', 'store')->name('store');

        Route::get('/{id}/edit', 'edit')
            ->whereNumber('id')
            ->name('edit');

        Route::put('/{id}', 'update')
            ->whereNumber('id')
            ->name('update');

        Route::delete('/{id}', 'destroy')
            ->whereNumber('id')
            ->name('destroy');
    });

// ==========================================
// DONORS - ADMIN
// ==========================================

Route::get('/donors', [DonorController::class, 'index'])
    ->name('donors.index');

Route::get('/donors/create', [DonorController::class, 'create'])
    ->name('donors.create');

Route::post('/donors', [DonorController::class, 'store'])
    ->name('donors.store');

Route::get('/donors/{donor}/edit', [DonorController::class, 'edit'])
    ->name('donors.edit');

Route::put('/donors/{donor}', [DonorController::class, 'update'])
    ->name('donors.update');

Route::delete('/donors/{donor}', [DonorController::class, 'destroy'])
    ->name('donors.destroy');

// ==========================================
// DONORS - PUBLIC
// ==========================================

Route::get('/donatur', [PublicDonorController::class, 'index'])
    ->name('donors.public.index');

Route::get('/donatur/{donor}', [PublicDonorController::class, 'show'])
    ->whereNumber('donor')
    ->name('donors.public.show');

// ==========================================
// DONATION
// ==========================================

Route::get('/campaigns/{id}/donate', [DonationController::class, 'create'])
    ->whereNumber('id')
    ->name('donations.create');

Route::post('/campaigns/{id}/donate', [DonationController::class, 'store'])
    ->whereNumber('id')
    ->name('donations.store');

Route::get('/donasi/pembayaran', [DonationController::class, 'paymentPending'])
    ->name('donations.payment-pending');

// --- RUTE AUTENTIKASI ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- RUTE PUBLIK ---
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaigns/{id}', [CampaignController::class, 'show'])->name('campaigns.show');

// --- RUTE LOGIN USER, STAFF & ADMIN (BISA TAMBAH CAMPAIGN) ---
Route::middleware(['auth', 'role:admin,staff,user'])->group(function () {
	Route::get('/user/campaigns/create', [CampaignController::class, 'create'])->name('user.campaigns.create');
	Route::post('/user/campaigns', [CampaignController::class, 'store'])->name('user.campaigns.store');
});

// --- RUTE PANEL KHUSUS STAFF & ADMIN (BISA EDIT & LIHAT TABEL ADMIN) ---
Route::middleware(['auth', 'role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
	Route::get('/campaigns', [CampaignController::class, 'adminIndex'])->name('campaigns.index');
	Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
	Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
	Route::get('/campaigns/{id}/edit', [CampaignController::class, 'edit'])->name('campaigns.edit');
	Route::put('/campaigns/{id}', [CampaignController::class, 'update'])->name('campaigns.update');
});

// --- RUTE KHUSUS ADMIN SAJA (BISA HAPUS CAMPAIGN) ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
	Route::delete('/campaigns/{id}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');
});

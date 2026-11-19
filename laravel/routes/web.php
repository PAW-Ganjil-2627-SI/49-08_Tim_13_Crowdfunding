
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\PublicDonorController;
use App\Http\Controllers\DonationController;

// ==========================================
// HOMEPAGE
// ==========================================

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

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

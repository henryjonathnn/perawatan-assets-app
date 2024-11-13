<?php

use App\Http\Controllers\AsetController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\KegiatanController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::resource('aset', AsetController::class)->parameters([
    'aset' => 'uuid'
]);

Route::get('aset/{uuid}/detail', [AsetController::class, 'detail']);
Route::get('aset/{uuid}/barcode', [BarcodeController::class, 'generate'])->name('barcode.generate');

Route::resource('kegiatan', KegiatanController::class);
Route::get('aset/{uuid}/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
Route::post('aset/{uuid}/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');  
Route::post('aset/{uuid}/update-from-kegiatan', [KegiatanController::class, 'asetUpdate'])->name('kegiatan.aset.update');

// AUTH

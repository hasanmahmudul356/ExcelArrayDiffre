<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MyController;


Route::get('/', [MyController::class, 'importExportView']);
Route::post('import', [MyController::class, 'import'])->name('import');

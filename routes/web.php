<?php

use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\TicketController;
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
    return view('welcome');
});

Route::get('dashboard', [TicketController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('create', [TicketController::class, 'create'])->middleware('agent');
Route::post('created',[TicketController::class, 'store'])->middleware(('agent'));
Route::delete('view/{ticket:title}/delete', [TicketController::class, 'destroy'])->middleware('agent');
Route::get('technicians', [TechnicianController::class, 'index'])->middleware('agent')->name('technicians');
Route::get('technicians/{technician:name}', [TechnicianController::class, 'show'])->middleware('agent');
Route::delete('technicians/{technician:name}/delete', [TechnicianController::class, 'destroy'])->middleware('agent');

Route::get('view/{ticket:title}', [TicketController::class, 'show'])->middleware(('auth'));
Route::get('update/{ticket:title}', [TicketController::class, 'edit'])->middleware(('auth'));
Route::post('updated/{ticket:title}',[TicketController::class, 'update'])->middleware(('auth'))->name('update-post');

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QssAuthController;
use App\Http\Controllers\BooksController;
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

Route::get('login', [QssAuthController::class, 'showLogin'])->name('login');
Route::post('login', [QssAuthController::class, 'login']);

Route::middleware('auth.qss')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('logout', [QssAuthController::class, 'logout'])->name('logout');

    Route::prefix('authors')
        ->name('authors.')
        ->middleware('author.exists')
        ->group(function () {
            Route::get('/', [AuthorsController::class, 'index'])->name('index');
            Route::get('{author}', [AuthorsController::class, 'show'])->name('show');
            Route::delete('{author}', [AuthorsController::class, 'delete'])
                ->middleware('author.can_be_deleted')
                ->name('delete');
        });

    Route::prefix('books')->name('books.')->group(function () {
        Route::get('create', [BooksController::class, 'create'])->name('create');
        Route::post('/', [BooksController::class, 'store'])->name('store');
        Route::delete('{book}', [BooksController::class, 'delete'])->name('delete');
    });
});

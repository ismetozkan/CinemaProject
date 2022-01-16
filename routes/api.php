<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\CinemaToMovieController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\ShowingController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
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

Route::prefix('cinemas')->group(function (){
    Route::any('/', [CinemaController::class,'read'])->name('cinema.read');
    Route::any('create', [CinemaController::class,'create'])->name('cinema.create');
    Route::any('show/{id}', [CinemaController::class,'show'])->name('cinema.show');
    Route::any('update/{id}', [CinemaController::class,'update'])->name('cinema.update');
    Route::any('delete/{id}', [CinemaController::class,'delete'])->name('cinema.delete'); // parent olduğu için silme yapmak için onDelete cascade vs?
});

Route::prefix('salons')->group(function (){
    Route::any('/', [SalonController::class,'read'])->name('salon.read');
    Route::any('create', [SalonController::class,'create'])->name('salon.create');
    Route::any('update/{id}', [SalonController::class,'update'])->name('salon.update');
    Route::any('show/{id}', [SalonController::class,'show'])->name('salon.show');
    Route::any('delete/{id}', [SalonController::class,'delete'])->name('salon.delete'); //parent olduğu için silme yapmak için onDelete cascade vs?
});

Route::prefix('movies')->group(function (){
    Route::any('/', [MovieController::class,'read'])->name('movie.read');
    Route::any('create', [MovieController::class,'create'])->name('movie.create');
    Route::any('update/{id}', [MovieController::class,'update'])->name('movie.update');
    Route::any('show/{id}', [MovieController::class,'show'])->name('movie.show');
    Route::any('delete/{id}', [MovieController::class,'delete'])->name('movie.delete'); //parent olduğu için silme yapmak için onDelete cascade vs?
});

Route::prefix('cnmtomovie')->group(function (){
    Route::any('/', [CinemaToMovieController::class,'read'])->name('cnmtomovie.read');
    Route::any('create', [CinemaToMovieController::class,'create'])->name('cnmtomovie.create');
    Route::any('update/{id}', [CinemaToMovieController::class,'update'])->name('cnmtomovie.update');
    Route::any('delete/{id}', [CinemaToMovieController::class,'delete'])->name('cnmtomovie.delete');
    Route::any('show/{id}', [CinemaToMovieController::class,'show'])->name('cnmtomovie.show');
});

Route::prefix('showings')->group(function (){
    Route::any('/', [ShowingController::class,'read'])->name('showing.read');
    Route::any('create', [ShowingController::class,'create'])->name('showing.create');
    Route::any('update/{id}', [ShowingController::class,'update'])->name('showing.update');
    Route::any('show/{id}', [ShowingController::class,'show'])->name('showing.show');
    Route::any('delete/{id}', [ShowingController::class,'delete'])->name('showing.delete'); //seat ın parentı olduğu için silme yapmak için onDelete cascade vs?
});
Route::prefix('seats')->group(function (){
    Route::any('/', [SeatController::class,'read'])->name('seat.read');
    Route::any('create', [SeatController::class,'create'])->name('seat.create');
    Route::any('update/{id}', [SeatController::class,'update'])->name('seat.update');
    Route::any('delete/{id}', [SeatController::class,'delete'])->name('seat.delete');
    Route::any('show/{id}', [SeatController::class,'show'])->name('seat.show');
});
Route::prefix('tickets')->group(function (){
    Route::any('/', [TicketController::class,'read'])->name('ticket.read');
    Route::any('create', [TicketController::class,'create'])->name('ticket.create');
    Route::any('update/{id}', [TicketController::class,'update'])->name('ticket.update');
    Route::any('delete/{id}', [TicketController::class,'destroy'])->name('ticket.delete');
    Route::any('/showing/{id}',[TicketController::class,'getByShowingId']); //verilen showing(gösterim) idye göre ticketları getiriyor
    Route::any('show/{id}', [TicketController::class,'show'])->name('ticket.show');
});



Route::any('/login',[\App\Http\Controllers\UserController::class,'read'])->name('user.asd');
Route::any('/register',[\App\Http\Controllers\UserController::class,'read'])->name('register.create');

Route::post('/logout',[LogoutController::class,'destroy'])->name('logout');

Route::get('/register',[RegisterController::class,'read'])->name('register');
Route::post('/register',[RegisterController::class,'create'])->name('registerstr');

<?php

use App\Http\Controllers\CustomController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;

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
/*
Route::middleware(['auth:sanctum', 'verified'])->get('/home', function () {
    return view('home');
})->name('home'); */



Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {


    Route::get('/save-event', [CustomController::class, 'save_event'])->name('save-event');

    Route::get('/teams', [CustomController::class, 'teams'])->name('teams')->middleware(['eventCheck']);
    Route::get('/matches/{teamNumber?}', [CustomController::class, 'matches'])->name('matches')->middleware(['eventCheck']);
    Route::get('/inspection/{teamId}', [NoteController::class, 'detail'])->name('note-detail')->middleware(['eventCheck']);
    /* Route::get('/api-test', [NoteController::class, 'api_test'])->name('api-test'); */
    /* Route::post('/upload/{id}', [NoteController::class, 'upload_photos'])->name('note.upload_photos');
    Route::delete('/delete/{id}', [NoteController::class, 'delete_photo'])->name('note.delete_photo'); */
});

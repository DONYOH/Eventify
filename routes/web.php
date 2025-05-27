<?php

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
    return redirect('login');
});

Auth::routes();

Route::get('/TableauBord', [App\Http\Controllers\MyController::class, 'TableauBord'])->name('TableauBord');
Route::get('/deconnexion', [App\Http\Controllers\MyController::class, 'deconnexion'])->name('deconnexion');

//Gestion des admins
Route::get('/Admin', [App\Http\Controllers\MyController::class, 'Admin'])->name('Admin');
Route::post('/Add_Admin', [App\Http\Controllers\MyController::class, 'Add_Admin'])->name('Add_Admin');
Route::get('/deleteUser/{id}', [App\Http\Controllers\MyController::class, 'deleteUser'])->name('deleteUser');
Route::post('/Update_Admin/{id}', [App\Http\Controllers\MyController::class, 'Update_Admin'])->name('Update_Admin');
Route::get('/Client', [App\Http\Controllers\MyController::class, 'Client'])->name('Client');


//gestion des types de place
Route::get('/Type_place', [App\Http\Controllers\MyController::class, 'Type_place'])->name('Type_place');
Route::post('/Add_type_place', [App\Http\Controllers\MyController::class, 'Add_type_place'])->name('Add_type_place');
Route::post('/Update_type_place/{id}', [App\Http\Controllers\MyController::class, 'Update_type_place'])->name('Update_type_place');
Route::get('/deleteTypePlace/{id}', [App\Http\Controllers\MyController::class, 'deleteTypePlace'])->name('deleteTypePlace');

//Gestion des Places
Route::get('/Place', [App\Http\Controllers\MyController::class, 'Place'])->name('Place');
Route::post('/Add_Place', [App\Http\Controllers\MyController::class, 'Add_Place'])->name('Add_Place');
Route::post('/Add_Price', [App\Http\Controllers\MyController::class, 'Add_Price'])->name('Add_Price');
Route::get('/deletePrice/{id}', [App\Http\Controllers\MyController::class, 'deletePrice'])->name('deletePrice');
Route::post('/Update_Price/{id}', [App\Http\Controllers\MyController::class, 'Update_Price'])->name('Update_Price');

//Gestion des catégories d'évenements
Route::get('/Categorie_event', [App\Http\Controllers\MyController::class, 'Categorie_event'])->name('Categorie_event');
Route::post('/Add_categorie', [App\Http\Controllers\MyController::class, 'Add_categorie'])->name('Add_categorie');
Route::get('/deleteAdmin/{id}', [App\Http\Controllers\MyController::class, 'deleteAdmin'])->name('deleteAdmin');
Route::post('/Update_categorie/{id}', [App\Http\Controllers\MyController::class, 'Update_categorie'])->name('Update_categorie');

//Gestion des evenements
Route::get('/Evenement', [App\Http\Controllers\MyController::class, 'Evenement'])->name('Evenement');
Route::post('/Add_Event', [App\Http\Controllers\MyController::class, 'Add_Event'])->name('Add_Event');
Route::get('/deleteEvent/{id}', [App\Http\Controllers\MyController::class, 'deleteEvent'])->name('deleteEvent');
Route::post('/Update_Event/{id}', [App\Http\Controllers\MyController::class, 'Update_Event'])->name('Update_Event');
Route::get('/Participant_Event/{id}', [App\Http\Controllers\MyController::class, 'Participant_Event'])->name('Participant_Event');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

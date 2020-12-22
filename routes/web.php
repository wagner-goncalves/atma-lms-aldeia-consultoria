<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLoggedController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\MaterialController;

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
    return view('auth.login');
});
  
Auth::routes();
  
//Route::get('/', [LoginController::class, 'login'])->name('home');

  
Route::group(['middleware' => ['auth']], function() {
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/aula/{curso}', [AulaController::class, 'index'])->name('aula')->where('curso', '[0-9]+');
    Route::get('/feedback/{curso}', [FeedbackController::class, 'index'])->name('feedback')->where('curso', '[0-9]+');        
    Route::post('/feedback/{curso}', [FeedbackController::class, 'store'])->name('feedback.store')->where('curso', '[0-9]+');
    Route::get('/certificado/{curso}', [CertificadoController::class, 'download'])->name('certificado.download')->where('curso', '[0-9]+');        

    //Route::get('foo/bar', 'FooController@bar');
    //Route::get('/users/edit-logged', [UserLoggedController::class, 'editLogged'])->name('users.edit-logged');
    //Route::post('/users/update-logged', [UserLoggedController::class, 'updateLogged'])->name('users.update-logged');

    Route::resource('materiais', MaterialController::class);
    Route::get('/materiais/download/{id}', [MaterialController::class, 'download'])->name('materiais.download');
    Route::post('/materiais/modulos', [MaterialController::class, 'modulos'])->name('materiais.modulos')->withoutMiddleware(['csrf']);
    Route::post('/materiais/aulas', [MaterialController::class, 'aulas'])->name('materiais.aulas')->withoutMiddleware(['csrf']);

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('userslogged', UserLoggedController::class);
    Route::resource('products', ProductController::class);
    //Route::resource('participantes', ParticipanteController::class);

});

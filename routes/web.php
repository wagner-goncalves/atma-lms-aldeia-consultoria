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
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\AulaAdministracaoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PlanoController;

use App\Http\Controllers\Auth\ExpiredPasswordController;

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


Route::get('mail', function () {
    $matricula = new \App\Models\Matricula();

    $matricula = $matricula->where('curso_id', '=', 1)
        ->where('user_id', '=', 1)
        ->where('empresa_id', '=', 1)
        ->first();

    $user = \App\Models\User::find(1);
    $empresa = \App\Models\Empresa::find(1);
    $curso = \App\Models\Curso::find(1);
    //$user->notify(new \App\Notifications\AlunoCadastrado());

    return (new \App\Notifications\AlunoCadastrado(
            $user, 
            $empresa, 
            $curso
            ))->toMail($user);
});
  
Route::group(['middleware' => ['auth']], function() {

    Route::middleware(['password_expired'])->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
    });    
    
   
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

    Route::resource('modulos', ModuloController::class);

    Route::resource('empresas', EmpresaController::class);

    Route::resource('planos', PlanoController::class);

    Route::resource('aulas', AulaAdministracaoController::class);

    Route::resource('matriculas', MatriculaController::class);
    Route::post('/matriculas/importar', [MatriculaController::class, 'importar'])->name('matriculas.importar');
    Route::post('/matriculas/planos', [MatriculaController::class, 'planos'])->name('matriculas.planos')->withoutMiddleware(['csrf']);
    Route::post('/matriculas/cursos', [MatriculaController::class, 'cursos'])->name('matriculas.cursos')->withoutMiddleware(['csrf']);
    Route::post('/matriculas/exportar', [MatriculaController::class, 'exportar'])->name('matriculas.exportar');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('/primeiro-acesso/{id}', [UserController::class, 'resetPassword'])->name('primeiro.acesso');

    Route::resource('userslogged', UserLoggedController::class);
    Route::resource('products', ProductController::class);
    //Route::resource('participantes', ParticipanteController::class);

    Route::get('/password/expired', [ExpiredPasswordController::class, 'expired'])->name('password.expired');
    Route::post('/password/post_expired', [ExpiredPasswordController::class, 'postExpired'])->name('password.post_expired');

});

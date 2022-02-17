<?php

use Illuminate\Support\Facades\Route;
use App\Mail\{MensagemMail};
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

Route::get('/tarefa/export/{extensao}', [App\Http\Controllers\TarefaController::class,'export'])->name('tarefa.export');

Auth::routes(['verify'  =>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('verified');

Route::resource('tarefa',TarefaController::class)->middleware('verified');



Route::get('/mensagem',function(){  Mail::to('xxx@xxx.xxx')->send(new MensagemMail());
                                    return 'email enviado';
                                });

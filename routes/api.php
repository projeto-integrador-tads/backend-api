<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// usados pela autenticação
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Password;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/* 
------------------------------------------------------------------------------------------------------------
/
/                                   Autenticação 
/
-----------------------------------------------------------------------------------------------------------
/
//// Proteger rotas ////////////////////////////////////////////////////////////////////////////////
/
/    use Illuminate\Http\Request;
/ 
/    Route::get('/user', function (Request $request) {
/        return $request->user();
/    })->middleware('auth:sanctum');
/
////////////////////////////////////////////////////////////////////////////////////////////////////
*/ 
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

/****************************************************************************************************
 * ******************************* Solicitação para Recuperar senha *********************************
 * **************************************************************************************************
 */

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
 
    $status = Password::sendResetLink(
        $request->only('email')
    );
 
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)]) 
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

/***************************************************************************************************
 * *********************************** Resetar senha ***********************************************
 * *************************************************************************************************
 */

Route::post('reset-password', function (Request $request) {
    // os atributos , e da solicitação token são email validados password
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
    // usando "password broker" integrado do Laravel
    $status = Password::reset( 
        //Se o token, endereço de e-mail e senha fornecidos ao corretor de senhas forem válidos, o closure passado ao reset método será invocado
        $request->only('email', 'password', 'password_confirmation', 'token'), 
        function (User $user, string $password) 
        { // Dentro desse closure, que recebe a instância do usuário e a senha em texto simples fornecida ao formulário de redefinição de senha
            $user->forceFill([
                'password' => Hash::make($password) // Atualiza a senha do usuário no banco de dados.
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PASSWORD_RESET 
                ? redirect()->route('login')->with('status', __($status)) // voltar para a página de login (se existir a view)
                : back()->withErrors(['email' => [__($status)]]); // retorna uma mensagem de erro
})->middleware('guest')->name('password.update');

/// 
//
/////////////////////////////////////////////////////////////////////////////////////////////
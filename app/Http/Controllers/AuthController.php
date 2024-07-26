<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $registerUserData = $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8'
        ]);
        $user = User::create([
            'name' => $registerUserData['name'],
            'email' => $registerUserData['email'],
            'password' => Hash::make($registerUserData['password']),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Usuário cadastrado com sucesso',
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        //Recebe os parametros a serem validados 
        $loginUserData = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:8'
        ]);
        $user = User::where('email',$loginUserData['email'])->first();
        if(!$user || !Hash::check($loginUserData['password'],$user->password)){
            return response()->json([
                'message' => 'Dados inseridos incorretamente'
            ],401);
        }
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token, 
            'message' => 'Usuário Logado'
        ]);
    }

    public function logout(Request $request){
        
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
          "message"=>"user logged out"
        ]);
    }
    /*
    public function forgotPassword (Request $request)
    { // esqueceu a senha
        
        //Buscando o usuário

        // $validate = Validator::make($request->all(),[
        //     'email' => 'required|string|email',
        // ]);

        
        $request->validate(['email'=>'required|email']);
        

        try 
        {

            // A resposta deve receber o RESET_LINK_SENT
            $response = Password::sendResetLink($request->only('email'));

            switch ($response){
                case Password::INVALID_USER:
                    return response()->json(['message' => 'Usuário Inválido'], 200);
                case Password::RESET_LINK_SENT:
                    return response()->json(['message' => 'O E-mail foi enviado com sucesso'], 200);
            }
        } 
        catch (Exception $e){
            return back()->withInput()->with('error','Erro ao enviar o formulário');
        }

        

    }

    public function resetPassword (Request $request) 
    { // resetar a senha 
        
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {

            $status = Password::reset(
                $request->only('email', 'password','token'),
                function ($user, $password) {
                    $user->password = Hash::make($password);
                    $user->setRememberToken(Str::random(60));
                    $user->save();
                }
            );
    
            switch ($status){
                case Password::INVALID_USER:
                    return response()->json(['message' => 'Usuário INVÁLIDO'], 200);
                case Password::PASSWORD_RESET:
                    return response()->json(['message' => 'Senha alterada com sucesso'], 200);
            }

        } catch (Exception $e ){
            return back()->withInput()->with('error','Erro ao redefinir a senha');
        }

    
    }
    */
    
}




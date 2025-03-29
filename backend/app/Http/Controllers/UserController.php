<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Telefone;
use App\Models\Email;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'senha' => 'required|string|min:8|confirmed',
            'cpf' => 'required|string|max:255|unique:users', 
            'data_nascimento' => 'required|date', 
            'telefones' => 'nullable|array',
            'telefones.*' => 'nullable|string', 
            'emails' => 'nullable|array',
            'emails.*' => 'nullable|string|email', 
        ]);

        // Criar o usuário
        $user = User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => bcrypt($request->senha),
            'cpf' => $request->cpf, 
            'data_nascimento' => $request->data_nascimento,
            'telefone' => $request->telefone, 
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'cep' => $request->cep,
        ]);

        // Associar telefones (se houver)
        if ($request->has('telefones')) {
            foreach ($request->telefones as $telefone) {
                $telefoneModel = Telefone::create(['numero' => $telefone]);
                $user->telefones()->attach($telefoneModel->id);
            }
        }

        // Associar e-mails (se houver)
        if ($request->has('emails')) {
            foreach ($request->emails as $email) {
                $emailModel = Email::create(['email' => $email]);
                $user->emails()->attach($emailModel->id);
            }
        }

        return response()->json($user, 201);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'senha' => 'required|string|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->senha, $user->senha)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        // Gerar o token JWT
        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Não foi possível gerar o token'], 500);
        }

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function listar()
    {
        $users = User::all();
        return response()->json($users);
    }
}

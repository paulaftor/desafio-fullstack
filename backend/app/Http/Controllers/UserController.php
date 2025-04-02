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
            'senha' => 'required|string|confirmed',
            'cpf' => 'required|string|size:11|unique:users',
            'data_nascimento' => 'required|date',
            'telefone' => 'required|string|max:15',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|size:2',
            'cep' => 'required|string|size:8',
            'parentesco' => 'nullable|string|max:255',
            'telefones' => 'nullable|array',
            'telefones.*' => 'nullable|string|max:15',
            'emails' => 'nullable|array',
            'emails.*' => 'nullable|string|email|max:255',
        ]);

        // Criar o usuário principal
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
            'parentesco' => $request->parentesco,
        ]);

        // Associar telefones adicionais (se houver)
        if ($request->has('telefones')) {
            foreach ($request->telefones as $telefone) {
                if (!empty($telefone)) {
                    $telefoneModel = Telefone::firstOrCreate(['telefone' => $telefone]); // Evita duplicação
                    $user->telefones()->attach($telefoneModel->id);
                }
            }
        }

        // Associar emails adicionais (se houver)
        if ($request->has('emails')) {
            foreach ($request->emails as $email) {
                if (!empty($email)) {
                    $emailModel = Email::firstOrCreate(['email' => $email]); // Evita duplicação
                    $user->emails()->attach($emailModel->id);
                }
            }
        }

        // retornar token tambem
        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Não foi possível gerar o token'], 500);
        }

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }



    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'senha' => 'required|string',
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


    public function update(Request $request, $id)
    {
        // Verificar se o usuário autenticado é o mesmo que está tentando atualizar
        $authenticatedUser = auth()->user();

        if ($authenticatedUser->id !== (int)$id) {
            return response()->json(['error' => 'Você não tem permissão para editar este usuário.'], 403);
        }

        // Validar os dados da requisição
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'cpf' => 'required|string|size:11|unique:users,cpf,' . $id,
            'data_nascimento' => 'required|date',
            'telefone' => 'required|string|max:15',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|size:2',
            'cep' => 'required|string|size:8',
            'parentesco' => 'nullable|string|max:255',
            'telefones' => 'nullable|array',
            'telefones.*' => 'nullable|string|max:15',
            'emails' => 'nullable|array',
            'emails.*' => 'nullable|string|email|max:255',
        ]);

        // Buscar o usuário pelo ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        // Atualizar os dados do usuário
        $user->update([
            'nome' => $request->nome,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'data_nascimento' => $request->data_nascimento,
            'telefone' => $request->telefone,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'cep' => $request->cep,
            'parentesco' => $request->parentesco,
        ]);

        // Atualizar os telefones, removendo os antigos e associando novos
        if ($request->has('telefones')) {
            $user->telefones()->detach();  // Remover todos os telefones atuais
            foreach ($request->telefones as $telefone) {
                if (!empty($telefone)) {
                    $telefoneModel = Telefone::firstOrCreate(['telefone' => $telefone]);
                    $user->telefones()->attach($telefoneModel->id);
                }
            }
        }

        // Atualizar os emails, removendo os antigos e associando novos
        if ($request->has('emails')) {
            $user->emails()->detach();  // Remover todos os emails atuais
            foreach ($request->emails as $email) {
                if (!empty($email)) {
                    $emailModel = Email::firstOrCreate(['email' => $email]);
                    $user->emails()->attach($emailModel->id);
                }
            }
        }

        // Retornar a resposta com o usuário atualizado
        return response()->json($user->load('telefones', 'emails'), 200);
    }



    public function listar(Request $request)
    {
        $perPage = 5; 
        $users = User::orderBy('updated_at', 'desc') 
                    ->paginate($perPage);
        return response()->json($users);
    }

}

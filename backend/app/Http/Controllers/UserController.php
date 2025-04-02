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
    /**
     * cadastra um novo usuário e associa telefones e emails.
     */
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

        // associar telefones adicionais (se houver)
        if ($request->has('telefones')) {
            foreach ($request->telefones as $telefone) {
                if (!empty($telefone)) {
                    $telefoneModel = Telefone::firstOrCreate(['telefone' => $telefone]); 
                    $user->telefones()->attach($telefoneModel->id);
                }
            }
        }

        // associar emails adicionais (se houver)
        if ($request->has('emails')) {
            foreach ($request->emails as $email) {
                if (!empty($email)) {
                    $emailModel = Email::firstOrCreate(['email' => $email]);
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

    /**
     * faz login e gera um token JWT.
     */
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

        // gerando token JWT
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

    /**
     * atualiza cadastro do usuário
     */
    public function update(Request $request, $id)
    {
        // verificar se o usuário autenticado é o mesmo que está tentando atualizar
        $authenticatedUser = auth()->user();

        if ($authenticatedUser->id !== (int)$id) {
            return response()->json(['error' => 'Você não tem permissão para editar este usuário.'], 403);
        }

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

        // buscar o usuário pelo ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

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

        // atualizar os telefones mantendo o principal
        if ($request->has('telefones')) {
            $telefones = collect($request->telefones)->unique()->filter(); // Remove duplicados e vazios

            $telefonePrincipal = $telefones->shift(); // primeiro telefone é principal
            $user->update(['telefone' => $telefonePrincipal]);

            // atualizar telefones secundários 
            $user->telefones()->sync([]); // remove apenas os telefones secundários
            foreach ($telefones as $telefone) {
                $telefoneModel = Telefone::firstOrCreate(['telefone' => $telefone]);
                $user->telefones()->attach($telefoneModel->id);
            }

            $user->touch();
        }

        if ($request->has('emails')) {
            $emails = collect($request->emails)->unique()->filter();

            $emailPrincipal = $emails->shift();
            $user->update(['email' => $emailPrincipal]);

            $user->emails()->sync([]);
            foreach ($emails as $email) {
                $emailModel = Email::firstOrCreate(['email' => $email]);
                $user->emails()->attach($emailModel->id);
            }

            $user->touch();
        }

        // buscar telefone secundário mais recente 
        $telefoneSecundario = $user->telefones()
        ->where('telefone', '!=', $user->telefone)
        ->latest('telefones.created_at')
        ->value('telefone');

        $emailSecundario = $user->emails()
        ->where('email', '!=', $user->email)
        ->latest('emails.created_at')
        ->value('email');

        $user->telefone2 = $telefoneSecundario;
        $user->email2 = $emailSecundario;

        // retornar o usuário com os dados adicionais
        return response()->json($user->load('telefones', 'emails'), 200);

    }

    /**
     * lista usuários com paginação e inclui telefones e emails
     */
    public function listar(Request $request)
    {
        $perPage = 5; 
        
        $users = User::with(['telefones' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'emails' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
        ->orderBy('updated_at', 'desc')
        ->paginate($perPage);
    
        $users->getCollection()->transform(function ($user) {
            $telefone2 = $user->telefones->where('telefone', '!=', $user->telefone)->first();
            $email2 = $user->emails->where('email', '!=', $user->email)->first();
    
            return [
                'id' => $user->id,
                'nome' => $user->nome,
                'cpf' => $user->cpf,
                'data_nascimento' => $user->data_nascimento,
                'telefone' => $user->telefone,
                'telefone2' => $telefone2 ? $telefone2->telefone : null,
                'email' => $user->email,
                'email2' => $email2 ? $email2->email : null,
                'cep' => $user->cep,
                'logradouro' => $user->logradouro,
                'numero' => $user->numero,
                'bairro' => $user->bairro,
                'cidade' => $user->cidade,
                'estado' => $user->estado,
                'parentesco' => $user->parentesco,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];
        });
    
        return response()->json($users);
    }
    

}

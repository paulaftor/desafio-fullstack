<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    use HasApiTokens;  // habilita autenticação via API tokens (Sanctum)

    protected $fillable = [
        'nome', 'email', 'senha', 'cpf', 'data_nascimento', 
        'telefone', 'logradouro', 'numero', 'bairro', 'cidade', 
        'estado', 'cep', 'parentesco'
    ];

    // campos que serão ocultados nas respostas JSON
    protected $hidden = [
        'senha', 'remember_token',
    ];

    // converter atributos automaticamente
    protected $casts = [
        'email_verified_at' => 'datetime',
        'senha' => 'hashed', 
    ];

    /**
     * relacionamento com telefones.
     */
    public function telefones()
    {
        return $this->belongsToMany(Telefone::class, 'contatos_telefone', 'usuario_id', 'telefone_id');
    }

    /**
     * relacionamento com emails.
     */
    public function emails()
    {
        return $this->belongsToMany(Email::class, 'contatos_email', 'usuario_id', 'email_id');
    }

    /**
     * pega identificador único do usuário para o JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); 
    }

    /**
     * declarações personalizadas para o JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return []; 
    }
}

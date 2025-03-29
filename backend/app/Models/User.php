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
    use HasApiTokens;  


    protected $fillable = [
        'nome', 'email', 'senha', 'cpf', 'data_nascimento', 
        'telefone', 'logradouro', 'numero', 'bairro', 'cidade', 
        'estado', 'cep', 'parentesco'
    ];

    protected $hidden = [
        'senha', 'remember_token',
    ];

  
    protected $casts = [
        'email_verified_at' => 'datetime',
        'senha' => 'hashed',
    ];

    // Relacionamento muitos para muitos com telefones 
    public function telefones()
    {
        return $this->belongsToMany(Telefone::class, 'contatos_telefone', 'usuario_id', 'telefone_id');
    }

    // Relacionamento muitos para muitos com emails
    public function emails()
    {
        return $this->belongsToMany(Email::class, 'contatos_email', 'usuario_id', 'email_id');
    }

    /**
     * Obter o identificador exclusivo do usuário para o JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); 
    }

    /**
     * Obter as declarações personalizadas para o JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return []; 
    }

}

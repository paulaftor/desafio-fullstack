<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    use HasFactory;

    protected $fillable = [
        'telefone', 
    ];

    // Relacionamento muitos para muitos com usuários
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'contatos_telefone', 'telefone_id', 'usuario_id');
    }
}

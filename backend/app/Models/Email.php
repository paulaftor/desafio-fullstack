<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 
    ];

    // Relacionamento muitos para muitos com usuários
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'contatos_email', 'email_id', 'usuario_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $table = 'pets';
    public $timestamps = true;
    protected $fillable = [
        'nome', 'idade', 'porte', 'perfil', 'cidade', 'estado', 'foto', 'cod_responsavel', 'cod_adotante'
    ];

    public function responsaveis()
    {
        return $this->belongsTo(Responsavel::class, 'cod_responsavel', 'cod_responsavel');
    }

    public function adotantes()
    {
        return $this->belongsTo(Adotante::class, 'cod_adotante', 'cod_adotante');
    }
}
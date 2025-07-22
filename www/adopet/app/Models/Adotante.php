<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adotante extends Model
{
    use HasFactory;

    protected $table = 'adotantes';
    public $timestamps = true;
    protected $hidden = ['foto'];
    protected $fillable = [
        'nome',
        'foto',
        'telefone',
        'cidade',
        'sobre',
        'email'
    ];

    public function pets()
    {
        return $this->hasMany(Pet::class, 'cod_adotante');
    }
}
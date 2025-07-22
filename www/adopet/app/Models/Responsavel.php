<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsavel extends Model
{
    use HasFactory;

    protected $table = 'responsaveis';
    public $timestamps = true;
    protected $fillable = [
        'nome',
        'telefone',
        'email'
    ];

    public function pets()
    {
        return $this->hasMany(Pet::class, 'cod_responsavel');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instituicao extends Model
{
    use HasFactory;

    protected $table = 'instituicoes';
    protected $primaryKey = 'cod_responsavel';
    public $timestamps = true;

    protected $fillable = [
        'cod_responsavel',
        'cnpj'
    ];

    public function responsaveis()
    {
        return $this->belongsTo(Responsavel::class, 'cod_responsavel', 'id');
    }
}
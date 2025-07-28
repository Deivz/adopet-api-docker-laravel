<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Person extends Model
{
  use HasFactory;

  protected $table = 'persons';
  protected $primaryKey = 'cod_responsible';
  public $timestamps = true;

  protected $fillable = [
    'cod_responsible',
    'cpf'
  ];

  public function responsible()
  {
    return $this->belongsTo(Responsible::class, 'cod_responsible', 'id');
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($person) {
      if (empty($person->uuid)) {
        $person->uuid = (string) Str::uuid();
      }
    });
  }
}

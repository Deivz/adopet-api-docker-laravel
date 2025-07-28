<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Institution extends Model
{
  use HasFactory;

  protected $primaryKey = 'cod_responsible';
  public $timestamps = true;

  protected $fillable = [
    'cod_responsible',
    'cnpj'
  ];

  public function responsible()
  {
    return $this->belongsTo(Responsible::class, 'cod_responsible', 'id');
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($institution) {
      if (empty($institution->uuid)) {
        $institution->uuid = (string) Str::uuid();
      }
    });
  }
}

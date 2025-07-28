<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Responsible extends Model
{
  use HasFactory;

  protected $table = 'responsibles';
  public $timestamps = true;
  protected $fillable = [
    'name',
    'phone',
    'email',
    'uuid'
  ];

  public function pet()
  {
    return $this->hasMany(Pet::class, 'cod_responsible');
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($responsible) {
      if (empty($responsible->uuid)) {
        $responsible->uuid = (string) Str::uuid();
      }
    });
  }
}

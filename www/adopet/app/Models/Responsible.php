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

  public function person()
  {
    return $this->hasOne(Person::class, 'cod_responsible');
  }
  
  public function institution()
  {
    return $this->hasOne(Institution::class, 'cod_responsible');
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

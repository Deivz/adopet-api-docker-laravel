<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Adopter extends Model
{
  use HasFactory;

  public $timestamps = true;
  protected $hidden = ['photo'];
  protected $fillable = [
    'name',
    'photo',
    'phone',
    'city',
    'about',
    'email'
  ];

  public function pet()
  {
    return $this->hasMany(Pet::class, 'cod_adopter');
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($adopter) {
      if (empty($adopter->uuid)) {
        $adopter->uuid = (string) Str::uuid();
      }
    });
  }
}

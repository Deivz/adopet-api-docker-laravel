<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pet extends Model
{
	use HasFactory;

	public $timestamps = true;
	protected $fillable = [
		'name',
		'age',
		'size',
		'temperament',
		'city',
		'country',
		'photo',
		'cod_responsible',
		'cod_adopter'
	];

	public function responsible()
	{
		return $this->belongsTo(Responsible::class, 'cod_responsible', 'cod_responsible');
	}

	public function adopter()
	{
		return $this->belongsTo(Adopter::class, 'cod_adopter', 'cod_adopter');
	}

	protected static function boot()
	{
		parent::boot();

		static::creating(function ($pet) {
			if (empty($pet->uuid)) {
				$pet->uuid = (string) Str::uuid();
			}
		});
	}
}

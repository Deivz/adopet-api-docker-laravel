<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'uuid' => $this->uuid,
      'type' => 'Pets',
      'attributes' => [
        'name' => $this->name,
        'age' => $this->age,
        'size' => $this->size,
        'temperament' => $this->temperament,
        'city' => $this->city,
        'country' => $this->country,
        'photo' => $this->photo,
        'responsible' => $this->cod_responsible,
        'adopter' => $this->cod_adopter,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at
      ]
    ];
  }
}

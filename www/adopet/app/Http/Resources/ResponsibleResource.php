<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponsibleResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'uuid' => $this->uuid,
      'type' => 'Responsible',
      'attributes' => [
        'name' => $this->name,
        'phone' => $this->phone,
        'email' => $this->email,
      ]
    ];
  }
}

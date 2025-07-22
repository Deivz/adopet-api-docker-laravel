<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'type' => 'Pets',
            'attributes' => [
                'name' => $this->nome,
                'age' => $this->idade,
                'size' => $this->porte,
                'temperament' => $this->perfil,
                'city' => $this->cidade,
                'country' => $this->estado,
                'photo' => $this->foto,
                'responsible' => $this->cod_responsavel,
                'adopter' => $this->cod_adotante,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
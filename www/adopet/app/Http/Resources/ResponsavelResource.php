<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponsavelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'type' => 'Pets',
            'attributes' => [
                'nome' => $this->nome,
                'telefone' => $this->idade,
                'email' => $this->porte,
            ]
        ];
    }
}
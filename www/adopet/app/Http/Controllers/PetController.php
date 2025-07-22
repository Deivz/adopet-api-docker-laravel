<?php

namespace App\Http\Controllers;

use App\Http\Resources\PetResource;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PetController extends Controller
{

    public function index(): Collection
    {
        // return Pet::all();
        $pets = Pet::all()->map(function($pet) {
            $pet->foto = url('api/storage/pets/' . $pet->foto);
            return $pet;
        });

        return $pets;
    }

    public function store(Request $request): JsonResponse | PetResource
    {
        try {
            $this->validateRequest($request);
        } catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->errors(),
            ], 400);
        }

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->storeAs('pets', $filename, 'public');
            $data['foto'] = $filename;
        }

        Pet::create($data);

        return response()->json([
            'success' => 'Pet cadastrado com sucesso!',
        ], 201);
    }


    public function show(Pet $pet): PetResource
    {
        $pet = Pet::find($pet->id);
        if ($pet) {
            $data = $pet;
            if ($pet->foto) {
                $path = storage_path('app/public/pets/' . $pet->foto);
                $data['foto'] = $path;
            }
            return new PetResource($data);
        }

        abort(404);
    }


    public function update(Request $request, Pet $pet): JsonResponse | PetResource
    {
        try {
            $this->validateRequest($request);
        } catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->errors(),
            ], 400);
        }

        $pet = Pet::find($pet->id);

        if ($pet) {
            $pet->update($request->all());

            return new PetResource($pet);
        }

        return response()->json([
            'errors' => 'Pet não encontrado',
        ], 404);
    }


    public function destroy(Pet $pet): JsonResponse
    {
        $pet = Pet::find($pet->id);
        if ($pet) {
            $pet->delete();
            return response()->json([
                'message' => 'Pet excluído com sucesso',
            ], 201);
        }

        abort(404);
    }

    public function validateRequest(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'nome' => [
                'bail', 'required', 'max:50',
                'regex:/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.\'-]+$/u'
            ],
            'idade' => [
                'bail', 'required', 'max:15'
            ],
            'porte' => [
                'bail', 'required', 'max:15'
            ],
            'perfil' => [
                'bail', 'required', 'max:30'
            ],
            'cidade' => [
                'bail', 'required', 'max:30',
                'regex:/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.\'-]+$/u'
            ],
            'estado' => [
                'bail', 'required', 'max:2'
            ],
            'foto' => [
                'bail', 'nullable', 'image', 'mimes: jpg,jpeg,png,bmp,svg', 'max:1000'
            ],
            'cod_responsavel' => [
                'bail', 'required', 'max:100'
            ]
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
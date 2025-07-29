<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResponsibleFormRequest;
use App\Http\Resources\ResponsibleResource;
use App\Models\Institution;
use App\Models\Person;
use App\Models\Responsible;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ResponsibleController extends Controller
{

  public function index(): AnonymousResourceCollection
  {
    return ResponsibleResource::collection(Responsible::all());
  }

  public function store(ResponsibleFormRequest $request): JsonResponse
  {
    $docValue = $request->input('document');
    $docLength = strlen($docValue);
    $columnName = $docLength === 11 ? 'cpf' : 'cnpj';
    $modelClass = $docLength === 11 ? Person::class : Institution::class;

    try {
      DB::transaction(function () use ($request, $modelClass, $columnName, $docValue) {
        $responsible = Responsible::create($request->validated()->except(['document']));

        $modelClass::create([
          'cod_responsible' => $responsible->id,
          $columnName => $docValue,
        ]);
      });

      return response()->json([
        'success' => 'Cadastro de responsável realizado com sucesso!',
      ], 201);
    } catch (\Throwable $th) {
      return response()->json([
        'errors' => $th->getMessage(),
      ], 500);
    }
  }

  public function show(string $uuid): ResponsibleResource
  {
    $responsible = Responsible::where('uuid', $uuid)->first();

    if ($responsible) {
      return new ResponsibleResource($responsible);
    }

    abort(404);
  }

  public function update(ResponsibleFormRequest $request, string $uuid): JsonResponse
  {
    $responsible = Responsible::where('uuid', $uuid)->first();

    $docValue = $request->validated('document');
    $docLength = strlen($docValue);
    $columnName = $docLength === 11 ? 'cpf' : 'cnpj';
    $relation = $docLength === 11 ? $responsible->person : $responsible->institution;

    try {
      if ($responsible) {
        DB::transaction(function () use ($responsible, $request, $relation, $columnName, $docValue) {
          $responsible->update(Arr::except($request->validated(), ['document']));

          $relation->update([
            $columnName => $docValue,
          ]);
        });

        return response()->json([
          'success' => 'Cadastro de responsável atualizado com sucesso!',
        ], 201);
      }

      abort(404);
    } catch (\Throwable $th) {
      return response()->json([
        'errors' => $th->getMessage(),
      ], 500);
    }
  }


  public function destroy(string $uuid): JsonResponse
  {
    $responsible = Responsible::where('uuid', $uuid)->first();

    try {
      if ($responsible) {
        DB::transaction(function () use ($responsible) {
          $responsible->delete();
        });

        return response()->json([
          'message' => 'Responsável excluído com sucesso',
        ], 204);
      }

      abort(404);
    } catch (\Throwable $th) {
      return response()->json([
        'errors' => $th->getMessage(),
      ], 500);
    }
  }
}

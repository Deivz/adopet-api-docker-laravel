<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResponsibleFormRequest;
use App\Http\Resources\ResponsibleResource;
use App\Models\Institution;
use App\Models\Person;
use App\Models\Responsible;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ResponsibleController extends Controller
{

  public function index(): Collection
  {
    return Responsible::all();
  }


  public function store(ResponsibleFormRequest $request): JsonResponse
  {
    $docValue = $request->input('document');
    $docLength = strlen($docValue);
    $columnName = $docLength === 11 ? 'cpf' : 'cnpj';
    $modelClass = $docLength === 11 ? Person::class : Institution::class;

    try {
      DB::transaction(function () use ($request, $modelClass, $columnName, $docValue) {
        $responsible = Responsible::create($request->except(['document']));

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
        'errors' => $th,
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


  public function update(Request $request, Responsible $responsible): JsonResponse | ResponsibleResource
  {
    foreach ($request->except(['nome', 'telefone', 'email']) as $key => $part) {
      $document = $key;
    }

    if ($document === 'cpf') {
      $model = 'Person';
      $table = 'pessoas';
    } else {
      $model = 'Institution';
      $table = 'instituicoes';
    }

    $modelClass = 'App\\Models\\' . $model;

    try {
      $this->validateRequest($request, $document, $table);
    } catch (ValidationException $exception) {
      return response()->json([
        'errors' => $exception->errors(),
      ], 400);
    }

    $responsible = Responsible::find($responsible->id);

    $modelClass::update([
      'cod_responsible' => $responsible->id,
      $document => $request->input($document)
    ]);

    if ($responsible) {
      $responsible->update($request->all());

      return new ResponsibleResource($responsible);
    }

    return response()->json([
      'errors' => 'Pet não encontrado',
    ], 404);
  }


  public function destroy(Responsible $responsible): JsonResponse
  {
    $responsible = Responsible::find($responsible->id);
    if ($responsible) {
      $responsible->delete();
      return response()->json([
        'message' => 'Responsável excluído com sucesso',
      ], 201);
    }

    abort(404);
  }
}

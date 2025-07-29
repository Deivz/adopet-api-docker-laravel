<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserFormRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	public function index(): AnonymousResourceCollection
	{
		return UserResource::collection(User::all());
	}

	public function store(UserFormRequest $request): JsonResponse
	{
		$data = $request->validated();
		$data['password'] = bcrypt($request->password);

		try {
			DB::transaction(function () use ($data) {
				User::create($data);
			});

			return response()->json([
				'success' => 'Seu cadastro foi realizado com sucesso!',
			], 201);
		} catch (\Throwable $th) {
			return response()->json([
				'errors' => $th->getMessage(),
			], 500);
		}
	}

	public function show(string $uuid): UserResource
	{
		$user = User::where('uuid', $uuid)->first();
		if ($user) {
			return new UserResource($user);
		}

		abort(404);
	}


	public function update(UserFormRequest $request, string $uuid): JsonResponse
	{
		$user = User::where('uuid', $uuid)->first();
		$data = $request->validated();
		$data['password'] = bcrypt($request->password);

		try {
			if ($user) {
				DB::transaction(function () use ($user, $data) {
					$user->update($data);
				});

				return response()->json([
					'success' => 'Usuário atualizado com sucesso',
				], 200);
			}

			return response()->json([
				'errors' => 'Usuário não encontrado',
			], 404);
		} catch (\Throwable $th) {
			return response()->json([
				'errors' => $th->getMessage(),
			], 500);
		}
	}

	public function destroy(string $uuid): JsonResponse
	{
		$user = User::where('uuid', $uuid)->first();

		try {
			if ($user) {
				DB::transaction(function () use ($user) {
					$user->delete();
				});

				return response()->json([
					'message' => 'Usuário excluído com sucesso',
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

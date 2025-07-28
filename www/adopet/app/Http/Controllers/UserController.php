<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	public function index(): Collection
	{
		return User::all();
	}

	public function store(UserFormRequest $request): JsonResponse
	{
		$data = $request->all();
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
				'errors' => $th,
			], 500);
		}
	}

	public function show(string $uuid): User
	{
		$user = User::where('uuid', $uuid)->first();
		if ($user) {
			return $user;
		}

		abort(404);
	}


	public function update(Request $request, User $user): JsonResponse
	{
		$user = User::find($user->id);

		try {
			if ($user) {
				DB::transaction(function () use ($user, $request) {
					$user->update($request->all());
				});

				return $user;
			}

			return response()->json([
				'errors' => 'Pet não encontrado',
			], 404);
		} catch (\Throwable $th) {
			return response()->json([
				'errors' => $th,
			], 500);
		}
	}

	public function destroy(User $user): JsonResponse
	{
		$user = User::find($user->id);

		try {
			if ($user) {
				DB::transaction(function () use ($user) {
					$user->delete();
				});

				return response()->json([
					'message' => 'Usuário excluído com sucesso',
				], 201);
			}

			abort(404);
		} catch (\Throwable $th) {
			return response()->json([
				'errors' => $th,
			], 500);
		}
	}
}

<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use function Psy\debug;

class UsuarioController extends Controller
{
	public function index(): Collection
	{
		return Usuario::all();
	}

	public function store(Request $request): JsonResponse
	{
		try {
			$this->validateRequest($request);
		} catch (ValidationException $exception) {
			return response()->json([
				'errors' => $exception->errors(),
			], 400);
		}

		$data = $request->all();
		
		$data['password'] = bcrypt($request->password);

		Usuario::create($data);

		return response()->json([
			'success' => 'Seu cadastro foi realizado com sucesso!',
		], 201);
	}


	public function show(Usuario $user): Usuario
	{
		$user = Usuario::find($user->id);
		if ($user) {
			return $user;
		}

		abort(404);
	}


	public function update(Request $request, Usuario $user): JsonResponse
	{
		try {
			$this->validateRequest($request);
		} catch (ValidationException $exception) {
			return response()->json([
				'errors' => $exception->errors(),
			], 400);
		}

		$user = Usuario::find($user->id);

		if ($user) {
			$user->update($request->all());

			return $user;
		}

		return response()->json([
			'errors' => 'Pet não encontrado',
		], 404);
	}


	public function destroy(Usuario $user): JsonResponse
	{
		$user = Usuario::find($user->id);
		if ($user) {
			$user->delete();
			return response()->json([
				'message' => 'Usuário excluído com sucesso',
			], 201);
		}

		abort(404);
	}

	public function validateRequest(Request $request): void
	{
		$validator = Validator::make($request->all(), [
			'name' => [
				'bail', 'required', 'max:50',
				'regex:/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.\'-]+$/u'
			],
			'email' => [
				'bail', 'required', 'email'
			],
			'password' => [
				'bail', 'required', 'max:15', 'required_with:password_confirmation|same:password_confirmation',
				'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$*&@#])[0-9a-zA-Z$*&@#]{6,}$/'
			],
			'password_confirmation' => [
				'bail', 'max:15', 'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$*&@#])[0-9a-zA-Z$*&@#]{6,}$/'
			]
		]);

		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
	}
}
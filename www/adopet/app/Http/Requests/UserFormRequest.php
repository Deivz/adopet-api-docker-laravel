<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'name' => [
        'bail',
        'required',
        'max:50',
        'regex:/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.\'-]+$/u'
      ],
      'email' => [
        'bail',
        'required',
        'email'
      ],
      'password' => [
        'bail',
        'required',
        'max:15',
        'same:password_confirmation',
        'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$*&@#])[0-9a-zA-Z$*&@#]{6,}$/'
      ],
      'password_confirmation' => [
        'bail',
        'required'
      ]
    ];
  }

  public function messages()
  {
    return [
      'name.required' => 'O campo nome é obrigatório.',
      'name.max' => 'O campo nome deve ter no máximo 50 caracteres.',
      'name.regex' => 'O campo nome deve conter somente letras, espaços, pontos, hífens, barra e aspas.',
      'email.required' => 'O campo e-mail é obrigatório.',
      'email.email' => 'O campo e-mail deve ser um endereço válido.',
      'password.required' => 'O campo senha é obrigatório.',
      'password.max' => 'O campo senha deve ter no máximo 15 caracteres.',
      'password.regex' => 'O campo senha deve conter pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial.',
      'password.same' => 'O campo confirmação de senha deve ser igual ao campo senha.',
      'password_confirmation.required' => 'O campo confirmação de senha é obrigatório.',
    ];
  }

  protected function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(response()->json([
      'message' => 'Erro de validação.',
      'errors' => $validator->errors(),
    ], 422));
  }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidateCpf;
use App\Rules\ValidateCnpj;

class ResponsibleFormRequest extends FormRequest
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
    $tableName = '';
    $doc = '';
    $docValue = $this->input('document');
    $docLength = strlen($docValue);

    switch ($docLength) {
      case 14:
        $doc = 'cnpj';
        $tableName = 'institutions';
        $docRule = new ValidateCnpj();
        break;

      default:
        $doc = 'cpf';
        $tableName = 'persons';
        $docRule = new ValidateCpf();
        break;
    }

    return [
      "name" => [
        "bail",
        "required",
        "max:150",
        "regex:/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.\"-]+$/u"
      ],
      "phone" => [
        "bail",
        "required",
        "max:15",
        "regex:/^\((?:[14689][1-9]|2[12478]|3[1234578]|5[1345]|7[134579])\) (?:[2-8]|9[1-9])[0-9]{3}\-[0-9]{4}$/"
      ],
      "email" => ["bail", "required", "max:150", "unique:responsibles"],
      "document" => [
        "bail",
        "required",
        $docRule,
        "unique:{$tableName},{$doc}",
      ],
    ];
  }

  public function messages()
  {
    return [
      "name.required" => "O campo nome é obrigatório.",
      "name.max" => "O campo nome deve ter no máximo 150 caracteres.",
      "name.regex" => "O campo nome deve conter somente letras, espaços, pontos, hífens, barra e aspas.",
      "phone.required" => "O campo telefone é obrigatório.",
      "phone.max" => "O campo telefone deve ter no máximo 15 caracteres.",
      "phone.regex" => "O campo telefone deve ser um telefone brasileiro.",
      "email.required" => "O campo e-mail é obrigatório.",
      "email.email" => "O campo e-mail deve ser um endereço válido.",
      "email.max" => "O campo e-mail deve ter no.maxcdn 150 caracteres.",
      "email.unique" => "O e-mail informado ja foi cadastrado.",
      "document.required" => "O campo documento é obrigatório.",
      "document.unique" => "O documento informado ja foi cadastrado.",
    ];
  }

  protected function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(response()->json([
      "message" => "Erro de validação.",
      "errors" => $validator->errors(),
    ], 422));
  }
}

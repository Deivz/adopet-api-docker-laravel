<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateCnpj implements ValidationRule
{
  /**
   * Run the validation rule.
   *
   * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
   */
  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
    $cnpj = preg_replace('/\D/', '', $value);

    if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
      $fail("O campo {$attribute} não é um CNPJ válido.");
      return;
    }

    $tamanho = 12;
    $multiplicadores = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    for ($i = 0; $i < 2; $i++) {
      $soma = 0;
      for ($j = 0; $j < $tamanho; $j++) {
        $soma += $cnpj[$j] * $multiplicadores[$j];
      }

      $resto = $soma % 11;
      $digito = ($resto < 2) ? 0 : 11 - $resto;

      if ($cnpj[$tamanho] != $digito) {
        $fail("O campo {$attribute} não é um CNPJ válido.");
        return;
      }

      $tamanho++;
      array_unshift($multiplicadores, 6); // adiciona 6 no início para o segundo dígito
    }
  }
}

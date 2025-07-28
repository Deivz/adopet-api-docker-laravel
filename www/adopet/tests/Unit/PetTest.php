<?php

namespace Tests\Unit;

use App\Models\Pet;
use PHPUnit\Framework\TestCase;

class PetTest extends TestCase
{
  public function test_if_columns_from_pets_are_correct(): void
  {
    $pet = new Pet;
    $expected = [
      'name',
      'age',
      'size',
      'temperament',
      'city',
      'country',
      'photo',
      'cod_responsible',
      'cod_adopter'
    ];

    $arrayComparison = array_diff($expected, $pet->getFillable());

    $this->assertEquals(0, count($arrayComparison));
  }

  // public function test_if_columns_from_pets_are_correct(): void
  // {
  //     $pet = Pet::make([
  //         'name' => 'Dunga',
  //         'age' => '2 anos',
  //         'size' => 'Pequeno',
  //         'temperament' => 'Alegre e esperto',
  //         'city' => 'Salvador',
  //         'country' => 'Bahia',
  //         'photo' => 'zxzxzx.png',
  //         'cod_responsible' => 2,
  //         'cod_adopter' => 2
  //     ]);
  //     $expected = [
  //         'name', 'age', 'size', 'temperament', 'city', 'country', 'photo', 'cod_responsible', 'cod_adopter'
  //     ];

  //     $arrayComparison = array_diff($expected, $pet->getFillable());

  //     $this->assertEquals(0, count($arrayComparison));
  // }
}

<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
  public function test_if_columns_from_users_are_correct(): void
  {
    $user = new User();
    $expected = [
      'name',
      'email',
      'password',
      'uuid'
    ];

    $arrayComparison = array_diff($expected, $user->getFillable());

    $this->assertEquals(0, count($arrayComparison));
  }
}

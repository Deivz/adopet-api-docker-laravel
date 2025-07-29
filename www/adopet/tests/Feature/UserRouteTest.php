<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserRouteTest extends TestCase
{
  public function test_validate_user_route_should_show_status_201_and_a_successful_message(): void
  {
    DB::beginTransaction();
    // Arrange
    $request = [
      "name" => "Bogobilz",
      "email" => "bogobilz@hotmail.com",
      "password" => "@Abc123",
      "password_confirmation" => "@Abc123",
    ];

    // Act
    $response = $this->post('/api/usuarios', $request);

    // Assert
    $response->assertStatus(201);
    $response->assertJson(["success" => "Usuário cadastrado com sucesso!"]);
    DB::rollBack();
  }
}

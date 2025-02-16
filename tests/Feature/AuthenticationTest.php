<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{

    use RefreshDatabase;

    public function test_register_a_new_user(): void
    {
        $response = $this->postJson('api/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'passwordtest123',
            'password_confirmation' => 'passwordtest123',
        ]);
    
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertHeader('Authorization');
    
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }
    
    public function test_login_existing_user(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('passwordtest123')
        ]);
    
        $response = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => 'passwordtest123',
        ]);
    
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertHeader('Authorization');
    
        $authorizationHeader = $response->headers->get('Authorization');
        $this->assertStringStartsWith('Bearer ', $authorizationHeader);
    }
    
    public function test_register_with_existing_email(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com'
        ]);

        $response = $this->postJson('api/register', [
            'name' => 'newUser',
            'email' => 'test@example.com',
            'password' => 'passwordtest123',
            'password_confirmation' => 'passwordtest123',
        ]);
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors'
        ]);
    
        $response->assertJsonFragment([
            'message' => 'Email already exists' 
        ]);
   
    }

    public function test_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('api/login', [
            'email' => 'invalid@example.com',
            'password' => 'invalidpassword',
        ]);
        $response->assertStatus(401);

        $response->assertJsonStructure([
            'message'
        ]);
    }
}

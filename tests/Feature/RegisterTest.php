<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_register_page(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('register');
        $response->assertSee('name="name"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('type="submit"', false);
    }

    public function test_proses_register_berjaya(): void
    {
        $data = [
            'name' => 'test1',
            'email' => 'test1@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];
        $response = $this->post('/register', $data);
        $response->assertStatus(302);
        $response->assertRedirect('/home');
    }

    public function test_register_gagal_email_sudah_digunakan(): void
    {
        // Create user
        $data = [
            'name' => 'test2',
            'email' => 'test2@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];
        //buat user
        \App\Models\User::create($data);
        //cuba daftar dengan user yang sama
        $response = $this->post('/register', $data);
        $response->assertSessionHasErrors(['email']);
    }
}

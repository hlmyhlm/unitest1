<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_page(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('login');
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('type="submit"', false);
    }

    public function test_berhasil_login(): void
    {
        User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => bcrypt('123456789'),
        ]);
        $credentials = [
            'email' => 'test@gmail.com',
            'password' => '123456789',
        ];
        $response = $this->post('/login', $credentials);
        $response->assertStatus(302);
        $response->assertRedirect('/home');
        $response->assertSessionHasNoErrors();
    }

    public function test_gagal_login()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors();
    }
}

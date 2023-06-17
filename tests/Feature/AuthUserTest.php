<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthUserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_auth_user_bisa_melihat_siswa(): void
    {
        $response = $this->get('/siswa');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}

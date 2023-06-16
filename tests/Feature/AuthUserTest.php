<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthUserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_tidak_bisa_tampil_siswa_tanpa_login(): void
    {
        $response = $this->get('/siswa');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}

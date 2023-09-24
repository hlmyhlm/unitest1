<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SiswaTest extends TestCase
{
    use RefreshDatabase;

    public function test_boleh_display_data(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
        ]);
        $this->actingAs($user);
        // User tambah data siswa
        $siswa1 = Siswa::create(['nama' => 'John Doe', 'alamat' => 'Jalan TAR']);
        $siswa2 = Siswa::create(['nama' => 'Jane Smith', 'alamat' => 'Putrajaya']);

        // Hantar permintaan GET ke route siswa
        $response = $this->get('/siswa');

        // Memastikan respons kod status 200 (OK)
        $response->assertStatus(200);
        // Memastikan respons berisi nama dan alamat siswa
        $response->assertSee($siswa1->nama);
        $response->assertSee($siswa1->alamat);
        $response->assertSee($siswa2->nama);
        $response->assertSee($siswa2->alamat);
    }

    public function test_display_form()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
        ]);
        $this->actingAs($user);
        $response = $this->get('/siswa/create');
        $response->assertStatus(200);
        $response->assertSee('name="nama"', false);
        $response->assertSee('name="alamat"', false);
    }

    public function test_validasi_semua_data_wajib_diisi()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
        ]);
        $this->actingAs($user);
        $response = $this->post('/siswa');
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['nama', 'alamat']);
    }

    public function test_boleh_simpan_data_siswa()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
        ]);
        $this->actingAs($user);
        $siswaData = [
            'nama' => 'John Doe',
            'alamat' => 'Putrajaya',
        ];
        $response = $this->post('/siswa', $siswaData);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('siswas', $siswaData);
    }

    public function test_boleh_display_form_edit()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
        ]);
        $this->actingAs($user);
        // Membuat data siswa
        $siswa = Siswa::create([
            'nama' => 'John Doe',
            'alamat' => 'Putrajaya',
        ]);

        // Mengirim permintaan GET ke page edit siswa
        $response = $this->get('/siswa/' . $siswa->id . '/edit');
        $response->assertStatus(200);
        $response->assertSee($siswa->nama, false);
        $response->assertSee($siswa->alamat, false);
    }

    public function test_boleh_update()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
        ]);
        $this->actingAs($user);
        // Membuat data siswa
        $siswa = Siswa::create([
            'nama' => 'John Doe',
            'alamat' => 'Putrajaya',
        ]);
        // Data siswa yang akan diupdate
        $updatedData = [
            'nama' => 'John Doe Updated',
            'alamat' => 'Putrajaya Updated',
        ];

        // Mengirim permintaan PUT untuk mengupdate data siswa
        $response = $this->put('/siswa/' . $siswa->id, $updatedData);
        $response->assertStatus(302);
        // Memastikan tidak ada error validasi
        $response->assertSessionHasNoErrors();
        // Memastikan data siswa berhasil diupdate di database
        $this->assertDatabaseHas('siswas', $updatedData);
    }

    public function test_boleh_hapus_data()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
        ]);
        $this->actingAs($user);
        // Membuat data siswa
        $siswa = Siswa::create([
            'nama' => 'John Doe',
            'alamat' => 'Putrajaya',
        ]);

        // Mengirim permintaan DELETE untuk menghapus data siswa
        $response = $this->delete('/siswa/' . $siswa->id);
        // Memastikan data siswa telah dihapus dari database
        $this->assertDatabaseMissing('siswas', ['id' => $siswa->id]);
    }
}

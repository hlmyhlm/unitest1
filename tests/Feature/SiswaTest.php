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
    /**
     * A basic feature test example.
     */
    public function test_bisa_tampil_data(): void
    {
        // Membuat data siswa
        $siswa1 = Siswa::create(['nama' => 'John Doe', 'alamat' => 'Jl. Merdeka']);
        $siswa2 = Siswa::create(['nama' => 'Jane Smith', 'alamat' => 'Jl. Pahlawan']);

        // Mengirim permintaan GET ke route siswa
        $response = $this->get('/siswa');

        // Memastikan respons kode status 200 (OK)
        $response->assertStatus(200);
        // Memastikan respons berisi nama dan alamat siswa
        $response->assertSee($siswa1->nama);
        $response->assertSee($siswa1->alamat);
        $response->assertSee($siswa2->nama);
        $response->assertSee($siswa2->alamat);
    }

    public function test_bisa_tampil_form()
    {
        $response = $this->get('/siswa/create');
        $response->assertStatus(200);
        $response->assertSee('name="nama"', false);
        $response->assertSee('name="alamat"', false);
    }

    public function test_validasi_semua_data_wajib_diisi()
    {
        $response = $this->post('/siswa');
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['nama', 'alamat']);
    }

    public function test_bisa_menyimpan_data_siswa()
    {
        $siswaData = [
            'nama' => 'John Doe',
            'alamat' => 'Jl. Merdeka',
        ];
        $response = $this->post('/siswa', $siswaData);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('siswas', $siswaData);
    }

    public function test_bisa_menampilkan_form_edit()
    {
        // Membuat data siswa
        $siswa = Siswa::create([
            'nama' => 'John Doe',
            'alamat' => 'Jl. Merdeka',
        ]);

        // Mengirim permintaan GET ke halaman edit siswa
        $response = $this->get('/siswa/' . $siswa->id . '/edit');
        $response->assertStatus(200);
        $response->assertSee($siswa->nama, false);
        $response->assertSee($siswa->alamat, false);
    }

    public function test_bisa_update()
    {
        // Membuat data siswa
        $siswa = Siswa::create([
            'nama' => 'John Doe',
            'alamat' => 'Jl. Merdeka',
        ]);
        // Data siswa yang akan diupdate
        $updatedData = [
            'nama' => 'John Doe Updated',
            'alamat' => 'Jl. Merdeka Updated',
        ];

        // Mengirim permintaan PUT untuk mengupdate data siswa
        $response = $this->put('/siswa/' . $siswa->id, $updatedData);
        $response->assertStatus(302);
        // Memastikan tidak ada error validasi
        $response->assertSessionHasNoErrors();
        // Memastikan data siswa berhasil diupdate di database
        $this->assertDatabaseHas('siswas', $updatedData);
    }

    public function test_bisa_hapus_data()
    {
        // Membuat data siswa
        $siswa = Siswa::create([
            'nama' => 'John Doe',
            'alamat' => 'Jl. Merdeka',
        ]);

        // Mengirim permintaan DELETE untuk menghapus data siswa
        $response = $this->delete('/siswa/' . $siswa->id);
        // Memastikan data siswa telah dihapus dari database
        $this->assertDatabaseMissing('siswas', ['id' => $siswa->id]);
    }
}
